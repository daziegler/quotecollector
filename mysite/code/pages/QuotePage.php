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
        'delete'
    );

    public function index(SS_HTTPRequest $request){
        $quotes = Quote::get()->innerJoin("Member", "\"Quote\".\"QuoteMemberID\" = \"Member\".\"ID\"");

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

    function QuoteForm() {
        $fields = new FieldList(
            new TextField('QuoteHeader'),
            new TextField('OriginalAuthor'),
            new TextField('AdditionalInfo'),
            new CheckboxSetField(
                $name = "tagField",
                $title = "Tags",
                $source = Tag::get()->map('ID', 'Title')
            ),
            new TextareaField('QuoteContent')
        );
        $actions = new FieldList(
            new FormAction('submit', 'Submit')
        );

        $validator = new RequiredFields('OriginalAuthor', 'QuoteContent');

        return new Form($this, 'QuoteForm', $fields, $actions, $validator);
    }

    public function submit($data, $form) {
        $submission = new Quote();
        if(isset($data['tagField'])){
            $submission->Tags=$data['tagField'];
        }
        $form->saveInto($submission);
        $submission->QuotePageID = $this->ID;

        $userID = Member::CurrentUser()->ID;
        $submission->QuoteMemberID = $userID;

        $submission->write();

        foreach($data['tagField'] as $key => $value){
            $quotation = DataObject::get_one('Tag',"ID = ".$value);
            $submission ->Tags()->add($quotation);
        }

        $form->sessionMessage('Quote wurde erfolgreich erstellt.', 'gut');

        return $this->redirectBack();
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