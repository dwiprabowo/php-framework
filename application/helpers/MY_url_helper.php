<?php
defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('site_url')){
    function site_url($uri = '', $protocol = NULL){
        $routes = get_instance()->router->routes;
        $lang_key = array_search($uri, $routes);
        if($lang_key){
            $uri = $lang_key;
        }
        return get_instance()->config->site_url($uri, $protocol);
    }
}