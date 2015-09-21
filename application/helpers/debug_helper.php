<?php
defined('BASEPATH') or exit('No direct script access allowed');

define('DEBUG_VAR_DUMP',    bindec('001'));
define('DEBUG_PRINT_R',     bindec('010'));
define('DEBUG_VAR_EXPORT',  bindec('100'));

if(!function_exists('ds')){
    function ds($something, $param = DEBUG_VAR_DUMP){
        ob_start();
        if($param & DEBUG_VAR_DUMP){
            var_dump($something);
        }elseif($param & DEBUG_VAR_EXPORT) {
            var_export($something);
        }elseif($param & DEBUG_PRINT_R){
            print_r($something);
        }else{
            var_dump("Unknown Param!");
        }
        return ob_get_clean();
    }
}