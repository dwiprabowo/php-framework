<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('twbs')){
    function twbs($rpath){
        return TWBS.$rpath;
    }
}
