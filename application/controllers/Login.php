<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends App_Controller{

    function __construct(){
        parent::__construct();
        if($this->login_model->ready()){
            redirect('dashboard');
        }
    }

    public function index(){}

    public function index_post(){
        $this->validate->setRules([
            'email ~ required|valid_email',
            'password ~ required',
        ]);
        if($this->validate->run()){
            $this->login();
        }
    }

    function login(){
        extract($this->input->post());
        $this->login_model->signIn($email, $password)
        or notif('message_invalid_user_login_info', false);
    }

    function _models(){
        return ['login'];
    }

}