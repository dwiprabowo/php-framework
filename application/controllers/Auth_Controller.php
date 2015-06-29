<?php
defined('BASEPATH') or exit('No direct access script allowed');

abstract class Auth_Controller extends Web_Controller{

    function __construct(){
        parent::__construct();
        if(!$this->login_model->ready()){
            $this->notif->addFlash('Please login!', 'warning');
            redirect('login');
        }
    }

    function _models(){
        return ['login'];
    }
}