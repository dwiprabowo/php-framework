<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('twbs')){
    function twbs($rpath){
        return base_url(TWBS.$rpath);
    }
}

if(!function_exists('twbs_textarea')){
    function twbs_textarea($data = '', $extra = '', $horizontal = false){
        $CI =& get_instance();

        is_array($data) or $data = array('name' => $data);
        $data['class'] = 'form-control';
        if(!isset($data['label'])){
            $label = $data['label'] = ucwords($data['name']);
        }else{
            $label = $data['label'];
        }
        $value = set_value($data['name']);
        isset($data['id']) or $id = $name = $data['id'] = $data['name'];

        if($horizontal){
            $horizontal = [
                'label' => @$horizontal['label']?:4,
                'input' => @$horizontal['input']?:8,
            ];
        }

        $view = form_textarea($data, $value, $extra);
        $data = compact(
            'name', 'id', 'label', 'value', 'extra', 'horizontal', 'view'
        );
        return $CI->load->view(
            'template/partial/twbs_form_group'
            , $data
            , true
        );
    }
}

if(!function_exists('twbs_input')){
    function twbs_input($data = '', $extra = '', $horizontal = false){
        $CI =& get_instance();

        is_array($data) or $data = array('name' => $data);
        $data['class'] = 'form-control';
        if(!isset($data['label'])){
            $label = $data['label'] = ucwords($data['name']);
        }else{
            $label = $data['label'];
        }
        $value = set_value($data['name']);
        isset($data['id']) or $id = $name = $data['id'] = $data['name'];

        if($horizontal){
            $horizontal = [
                'label' => @$horizontal['label']?:4,
                'input' => @$horizontal['input']?:8,
            ];
        }

        $view = form_input($data, $value, $extra);
        $data = compact(
            'name', 'id', 'label', 'value', 'extra', 'horizontal', 'view'
        );
        return $CI->load->view(
            'template/partial/twbs_form_group'
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

if(!function_exists('twbs_h_textarea')){
    function twbs_h_textarea($data = '', $extra = ''){
        return twbs_textarea($data, $extra, true);
    }
}