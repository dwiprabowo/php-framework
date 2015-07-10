<?php
defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('lang_url_prefix')){
    function lang_url_prefix($key){
        return "_".$key;
    }
}

if(!function_exists('url')){
    function url($uri){
        $uri = implode(
            '/'
            , array_map(
                't'
                , array_map(
                    'lang_url_prefix'
                    , array_filter(explode('/', $uri))
                )
            )
        );
        return base_url($uri);
    }
}

if(!function_exists('notif')){
    function notif($key, $flash = true){
        $CI =& get_instance();
        $type = false;
        if(is_array($key)){
            $type = $key[0];
            $key = $key[1];
        }
        $method_name = 'addFlash';
        if(!$flash){
            $method_name = 'add';
        }
        $CI->notif->{$method_name}(t($key)?:$key, $type);
    }
}

if(!function_exists('get_domain')){
    function get_domain($lang){
        $available_languages = config_item('available_languages');
        $lang = @$available_languages[$lang];
        if(!$lang){
            show_error("$lang language is not defined.");
        }else{
            if(@$lang['default']){
                return "";
            }else{
                return $lang['code'];
            }
        }
    }
}

if(!function_exists('base_domain')){
    function base_domain($lang){
        $code = get_domain($lang);
        return 'http://'.strtolower($code).($code?'.':'').PROJECT_DOMAIN;
    }
}

if(!function_exists('t')){
    function t($key){
        return lang($key)?:$key;
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