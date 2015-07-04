<?php
defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('clean_string')){
    function clean_string($input){
        $result = preg_replace('!\s+!', ' ', $input);
        $result = trim($result);
        return $result;
    }
}