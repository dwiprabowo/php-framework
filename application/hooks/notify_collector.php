<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotifyCollector{
    
    function run(){
        $CI =& get_instance();
        if(isset($CI->notif)){
            $CI->notif->collect();
        }
    }
}
