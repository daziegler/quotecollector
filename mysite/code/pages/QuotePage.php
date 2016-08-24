<?php

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 05.08.2016
 * Time: 09:24
 */
class QuotePage extends Page{

    private static $has_many = array(
        'Tags' => 'Tag'
    );

    public function getCMSFields(){
        $fields = parent::getCMSFields();

        $fields->removeByName('Content');
        $fields->removeByName('Metadata');

        $conf = GridFieldConfig_RecordEditor::create();
        $quoteGrid = GridField::create('Tags', _t('QuotePage.Tags', 'Tags'), $this->Tags(), $conf);

        $fields->addFieldToTab('Root.Main', $quoteGrid);

        return $fields;
    }
}

class QuotePage_Controller extends Page_Controller{

    public static $allowed_actions = array (
        'QuoteForm',
        'edit',
        'delete'
    );

    public function index(SS_HTTPRequest $request){
        $userID = Member::currentUserID();
        $quotes = Quote::get()->filter(array(
             'QuoteMemberID' => $userID
        ));

        if($search = $request->getVar('Author')) {
            $quotes = $quotes->filter(array(
                'OriginalAuthor:PartialMatch' => $search
            ));
        }

        if($search = $request->getVar('AdditionalInfo')) {
            $quotes = $quotes->filter(array(
                'AdditionalInfo:PartialMatch' => $search
            ));
        }

        if($search = $request->getVar('QuoteContent')) {
            $quotes = $quotes->filter(array(
                'QuoteContent:PartialMatch' => $search
            ));
        }

        if($tags = $request->getVar('tagField')) {
            $quotes = $quotes->filter(array(
                'Tags.ID:ExactMatch' => $tags
            ));
        }

        $paginatedQuotes = PaginatedList::create(
            $quotes,
            $request
        )   ->setPageLength(8)
            ->setPaginationGetVar('q');

        return array (
            'Results' => $paginatedQuotes
        );
    }

    public function QuoteForm(){

        $action = $this->request->param('Action');
        $id = (int)$this->request->param('ID');
        $quote = ($id) ? $quote = Quote::get()->byID($id) : false;
        $submitCaption = ($quote) ? 'Edit' : 'Create';

        $fields = new FieldList(
            TextField::create('QuoteHeader')
                ->setAttribute('placeholder', 'Header'),
            TextField::create('OriginalAuthor')
                ->setAttribute('placeholder', 'Author'),
            TextField::create('AdditionalInfo')
                ->setAttribute('placeholder', 'Additional Information'),
            CheckboxSetField::create('tagField', 'Tags', Tag::get()->map('ID', 'Title'))
                ->addExtraClass("tagField"),
            HtmlEditorField::create('QuoteContent')
                ->setAttribute('placeholder', 'Content of the Quote'),
            HiddenField::create('ID', 'ID')
                ->setValue($id)
        );
        $actions = FieldList::create(
            FormAction::create('submit', $submitCaption)
        );
        $validator = RequiredFields::create('OriginalAuthor', 'QuoteContent');

        $form = new Form($this, 'QuoteForm', $fields, $actions, $validator);

        if ($quote) {
            $form->loadDataFrom($quote);
        }

        return $form;
    }

    public function submit($data, $form) {
        $quote = new Quote();
        if(isset($data['tagField'])){
            $quote->Tags=$data['tagField'];
        }
        $form->saveInto($quote);
        $quote->QuotePageID = $this->ID;

        $userID = Member::CurrentUser()->ID;
        $quote->QuoteMemberID = $userID;

        $quote->ID = $data['ID'];
        $id = $quote->write();
        $quote->write();

        foreach($data['tagField'] as $key => $value){
            $quotation = DataObject::get_one('Tag',"ID = ".$value);
            $quote ->Tags()->add($quotation);
        }

        return $this->redirect($this->Link() . "edit/$id");
    }

    public function delete(){
        $QuoteID = $this->request->param('ID');

        if ($QuoteID && $quote = Quote::get()->byID($QuoteID)) {
            $quote->delete();
        }

        return $this->redirectBack();
    }

    public function QuoteSearchForm() {
        $form = Form::create(
            $this,
            'QuoteSearchForm',
            FieldList::create(
                TextField::create('Author')
                    ->setAttribute('placeholder', 'Author'),
                TextField::create('AdditionalInfo')
                    ->setAttribute('placeholder', 'Additional Information'),
                TextField::create('QuoteContent')
                    ->setAttribute('placeholder', 'Content of the Quote'),
                CheckboxSetField::create('tagField', 'Tags', Tag::get()->map('ID', 'Title'))
                    ->addExtraClass("tagField")
                    ->setValue('0')
            ),
            FieldList::create(
                FormAction::create('doQuoteSearch','Search')
            )
        );

        $form->setFormMethod('GET')
            ->setFormAction($this->Link())
            ->disableSecurityToken()
            ->loadDataFrom($this->request->getVars());
        return $form;
    }
}