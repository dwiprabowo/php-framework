<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends Web_Controller{

    function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->login_model->signOut();
    }

    function _models(){
        return ['login'];
    }
}