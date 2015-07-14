<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Start extends App_Controller{

    function index(){
        show_error(t('message_db_not_ready'));
    }

    function user_post(){
        $data = $this->input->post(null);
        $this->validate->setRules([
            'email ~ required|valid_email|autocorrect[email]',
            'password ~ required|min_length[8]',
        ]);
        if($this->validate->run()){
            $this->user_model->insert($data);
            redirect();
        }
    }

    function _models(){
        return ['user'];
    }
}