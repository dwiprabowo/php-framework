<?php
defined('BASEPATH') or exit('No direct access script allowed');

class AutoCorrect{

    const ITEM_NAME = 0, RULE_NAME = 1;

    private $availableCore = [
        'name', 'phone'
    ];

    function __construct(){
        $CI =& get_instance();
    }

    function run($value, $type){
        if(in_array($type, $this->availableCore)){
            $value = $this->{'c_'.$type}($value);
        }
        return $value;
    }

    private function c_name($value){
        return ucwords(strtolower(clean_string($value)));
    }
}