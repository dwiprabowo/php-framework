<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
    function site_url($uri = '', $protocol = NULL){
        $uri = t_uri($uri);
        return get_instance()->config->site_url($uri, $protocol);
    }
}