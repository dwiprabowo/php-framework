<?php
defined('BASEPATH') OR exit('No direct access script allowed');

class MY_Form_validation extends CI_Form_validation{

    private $autocorrect = [];

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
            $rules = $this->buildAutoCorrect($field, $rule);
            $item = compact('field', 'label', 'rules');
            array_push($result, $item);
        }
        return $result;
    }

    protected function _execute($row, $rules, $postdata = NULL, $cycles = 0){
        parent::_execute($row, $rules, $postdata, $cycles);
        $field = $row['field'];
        $rules = $row['rules'];
        $autocorrect = @$this->autocorrect[$field][AutoCorrect::RULE_NAME];
        if(!is_array($postdata) and $autocorrect){
            $error = @$this->_error_array[$field];
            if(!$error){
                $this->_field_data[$field]['postdata'] = $this->CI->ac->run($postdata, $autocorrect);
            }
        }
    }

    private function buildAutoCorrect($field, $rules){
        $rules = explode('|', $rules);
        if($autocorrect = $this->needAutoCorrect($rules)){
            $this->autocorrect[$field] = $autocorrect;
            $rules = array_diff($rules, [$autocorrect[AutoCorrect::ITEM_NAME]]);
        }
        return implode('|', $rules);
    }

    private function needAutoCorrect($rules, $find_rule = false){
        $result = array_map([$this, 'isAutoCorrect'], $rules);
        $result = array_filter($result);
        if($result){
            $result = current($result);
        }
        return $result;
    }

    private function isAutoCorrect($rule, $return_full = false){
        $subject = $rule;
        $pattern = '/^autocorrect\[([a-z]{4,})\]$/';
        preg_match($pattern, $subject, $result);
        return $result;
    }

}