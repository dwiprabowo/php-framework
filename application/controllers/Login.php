<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Web_Controller{

    function __construct(){
        parent::__construct();
    }

    public function index(){}

    public function index_post(){
        $this->validate->setRules([
            'email ~ required|valid_email',
            'password ~ required',
        ]);
        if($this->validate->run() == false){
        }
    }

    function _models(){
        return ['user'];
    }

}