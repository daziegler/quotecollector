<?php

/**
 * Created by PhpStorm.
 * User: ZSK
 * Date: 14.08.2016
 * Time: 16:58
 */
class QuoteMember extends DataExtension{
    private static $has_many = array(
        'Quotes' => 'Quote'
    );
}