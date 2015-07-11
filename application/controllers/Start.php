<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Start extends Web_Controller{

    function index(){
        if($this->database_model->ready()){
            redirect('master/create');
        }else{
            show_error(t('message_db_not_ready'));
        }
    }

    function _models(){
        return ['database'];
    }
}