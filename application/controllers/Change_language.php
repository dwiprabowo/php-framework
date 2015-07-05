<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Change_language extends Web_Controller{

    function index($language){
        if(!$language){
            $this->notif->addFlash(lang('message_change_lang_no_value'));
            redirect();
        }
    }
}