<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends Web_Controller{

    function create(){
        if(!$this->database_model->noUser()){
            redirect('login');
        }
    }

    function create_post(){
        $this->validate->setRules([
            'email ~ required|valid_email|autocorrect[email]',
            'password ~ required|min_length[8]',
        ]);
        if($this->validate->run()){
            redirect('login');
        }
    }

    function _models(){
        return ['database'];
    }
}