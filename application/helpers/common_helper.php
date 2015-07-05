<?php
defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('base_domain')){
    function base_domain($code = false){
        return 'http://'.strtolower($code).($code?'.':'').PROJECT_DOMAIN;
    }
}

if(!function_exists('t')){
    function t($key){
        return lang($key);
    }
}

if(!function_exists('country')){
    function country($code){
        return @config_item($code)[$code];
    }
}

if(!function_exists('active_if_lang')){
    function active_if_lang($lang){
        if(is_lang($lang)){
            return " active";
        }
        return "";
    }
}

if(!function_exists('is_lang')){
    function is_lang($lang){
        if($lang === config_item('language')){
            return true;
        }
        return false;
    }
}

if(!function_exists('clean_string')){
    function clean_string($input){
        $result = preg_replace('!\s+!', ' ', $input);
        $result = trim($result);
        return $result;
    }
}

if(!function_exists('clean_spaces')){
    function clean_spaces($input){
        $result = preg_replace('!\s+!', '', $input);
        $result = trim($result);
        return $result;
    }
}