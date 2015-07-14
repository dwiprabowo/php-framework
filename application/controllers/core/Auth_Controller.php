<?php
defined('BASEPATH') or exit('No direct access script allowed');

abstract class Auth_Controller extends App_Controller{

    function __construct(){
        parent::__construct();
        if(!$this->login_model->ready()){
            notif(['warning', 'message_please_login']);
            $this->login_model->deleteData();
            redirect('login');
        }
        $this->_initUser();
    }

    function _initUser(){
        $this->_var(
            'nav_profile_picture'
            , $this->login_model->getProfilePicture()
        );
    }

    function _models(){
        return ['login'];
    }
}