<?php
defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('current_uri')){
    function current_uri($lang){
        return get_instance()->_getCurrentURI()[$lang];
    }
}

if(!function_exists('t_uri')){
    function t_uri($uri = ''){
        if(is_array($uri)){
            $items = [];
            foreach ($uri as $item) {
                array_push($items, t_uri($item));
            }
            $uri = $items;
        }else{
            $routes = get_instance()->router->routes;
            $lang_key = array_search($uri, $routes);
            if($lang_key){
                $uri = $lang_key;
            }
        }

        return $uri;
    }
}

if(!function_exists('site_url')){
    function site_url($uri = '', $protocol = NULL, $harduse = false){
        $uri = t_uri($uri);
        if($uri === current_uri(config_item('language')) && !$harduse){
            return "javascript:void(0)";
        }
        return get_instance()->config->site_url($uri, $protocol);
    }
}

if(!function_exists('class_active')){
    function class_active($uri, $nameonly = false){
        if(site_url($uri) === "javascript:void(0)"){
            if(!$nameonly){
                return 'class="active"';
            }else{
                return 'active';
            }
        }
        return "";
    }
}