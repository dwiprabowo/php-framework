<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Web_Controller{

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
        or $this->notif->add('Invalid user login!');
    }

    function _models(){
        return ['login'];
    }

}