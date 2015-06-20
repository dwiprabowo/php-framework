<?php
defined('BASEPATH') OR exit('No direct access script allowed');

class MY_Form_validation extends CI_Form_validation{

    function __construct($rules = []){
        parent::__construct($rules);
    }

    public function setRules($rules){
        $rules = $this->buildRules($rules);
        $this->set_rules($rules);
        return $this;
    }

    private function buildRules($rules){
        $result = [];
        foreach ($rules as $key => $value) {
            $items = array_map('trim', explode('~', $value));
            if(count($items) === 3){
                list($field, $label, $rule) = $items;
            }elseif(count($items) === 2){
                list($field, $rule) = $items;
                $label = ucwords($field);
            }
            $item = compact('field', 'label', 'rule');
            array_push($result, $item);
        }
        return $result;
    }
}