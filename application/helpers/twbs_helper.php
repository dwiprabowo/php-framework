<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('twbs')){
    function twbs($rpath){
        return base_url(TWBS.$rpath);
    }
}

if(!function_exists('twbs_input')){
    function twbs_input($data = '', $extra = '', $horizontal = false){
        $CI =& get_instance();
        is_array($data) OR $data = array('name' => $data);
        $data['class'] = 'form-control';
        if(!isset($data['label'])){
            $data['label'] = ucwords($data['name']);
        }
        if($horizontal){
            $horizontal = [
                'label' => @$horizontal['label']?:4,
                'input' => @$horizontal['input']?:8,
            ];
        }
        $value = set_value($data['name']);
        isset($data['id']) OR $data['id'] = $data['name'];
        $data = compact('data', 'value', 'extra', 'horizontal');
        return $CI->load->view(
            'template/partial/twbs_input'
            , $data
            , true
        );
    }
}

if(!function_exists('twbs_h_input')){
    function twbs_h_input($data = '', $extra = ''){
        return twbs_input($data, $extra, true);
    }
}