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

    function QuoteForm() {
        $fields = new FieldList(
            new TextField('QuoteHeader'),
            new TextField('OriginalAuthor'),
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
        //$data['tagField']->Quote()->add($submission);

        $form->sessionMessage('Quote wurde erfolgreich erstellt.', 'gut');

        // ID | QuoteID | TagID (multiple)
        // Pro Checkbox in Field: 1 TagID
        // TagIDs -> $this->QuoteID
        //DB::getGeneratedID($Quote);

        //print '<pre>';print_r($data);exit();
        return $this->redirectBack();
    }

    public function delete(){
        $QuoteID = $this->request->param('ID');

        if ($QuoteID && $quote = Quote::get()->byID($QuoteID)) {
            $quote->delete();
        }

        return $this->redirectBack();
    }
}