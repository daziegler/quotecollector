<?php

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 05.08.2016
 * Time: 09:28
 */
class Tag extends DataObject{
    private static $db = array(
        'Title' => 'Varchar'
    );

    private static $belongs_many_many = array(
        'Quote' => 'Quote'
    );

    public function getCMSFields(){
        $fields = parent::getCMSFields();
        $fields->removeByName('QuoteID');
        return $fields;
    }
}