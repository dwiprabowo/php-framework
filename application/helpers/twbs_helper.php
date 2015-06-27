<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('twbs')){
    function twbs($rpath){
        return TWBS.$rpath;
    }
}

if(!function_exists('twbs_input')){
    function twbs_input($data = '', $extra = ''){
        $CI =& get_instance();
        is_array($data) OR $data = array('name' => $data);
        $data['class'] = 'form-control';
        $data['label'] = ucwords($data['name']);
        $value = set_value($data['name']);
        isset($data['id']) OR $data['id'] = $data['name'];
        $data = compact('data', 'value', 'extra');
        return $CI->load->view(
            'template/partial/twbs_input'
            , $data
            , true
        );
    }
}