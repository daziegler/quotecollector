<?php

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 05.08.2016
 * Time: 09:24
 */
class QuotePage extends Page{

    private static $has_many = array(
        'Quotes' => 'Quote'
    );

    public function getCMSFields(){
        $fields = parent::getCMSFields();

        $fields->removeByName('Content');
        $fields->removeByName('Metadata');

        $conf = GridFieldConfig_RecordEditor::create();
        $quoteGrid = GridField::create('Quotes', _t('QuotePage.Quotes', 'Zitate'), $this->Quotes(), $conf);

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
        $quotes = Quote::get()->limit(20);

        if($search = $request->getVar('Keywords')) {
            $quotes = $quotes->filter(array(
                'OriginalAuthor:PartialMatch' => $search,
                'AdditionalInfo:PartialMatch' => $search
            ));
        }

        /*
         * Needed: Tag ID in Quote
        if($tags = $request->getVar('tagField')) {
            $quotes = $quotes->filter(array(
                'ID:PartialMatch' => $tags
            ));
        }
        */

        return array (
            'Results' => $quotes
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
                TextField::create('Keywords')
                    ->setAttribute('placeholder', 'Header, Author, Additional Info etc...'),
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