<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotifyCollector{
    
    function run(){
        $CI =& get_instance();
        $CI->notif->collect();
    }
}
