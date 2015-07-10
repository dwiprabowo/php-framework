<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends Web_Controller{

    function create(){
        if($this->database_model->noUser()){
            
        }
    }

    function create_post(){
        $this->validate->setRules([
        ]);
    }

    function _models(){
        return ['database'];
    }
}