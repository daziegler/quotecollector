<?php

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 05.08.2016
 * Time: 09:24
 */
class Quote extends DataObject{

    private static $db = array(
        'QuoteHeader' => 'Text',
        'OriginalAuthor' => 'Text',
        'AdditionalInfo' => 'Text',
        'QuoteContent' => 'HTMLText'
    );

    private static $belongs_many_many = array(
        'Tags' => 'Tag'
    );

    private static $has_one = array(
        'QuotePage' => 'QuotePage'
    );

    private static $singular_name = 'Quote';
    private static $plural_name = 'Quotes';

    public function getCMSFields(){
        $fields = parent::getCMSFields();
        $fields->removeByName('QuotePageID');
        return $fields;
    }

    function getCMSValidator() {
        return new RequiredFields(array('QuoteContent, QuoteAuthor'));
    }
}