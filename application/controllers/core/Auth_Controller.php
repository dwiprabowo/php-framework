<?php
defined('BASEPATH') or exit('No direct access script allowed');

abstract class Auth_Controller extends App_Controller{

    private $user = false;

    function __construct(){
        parent::__construct();
        $this->user = $this->login_model->ready();
        if(!$this->user){
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
        $user_label = $this->user->fullname?:($this->user->email);
        $this->_var('user_label', $user_label);
    }

    function _models(){
        return ['login'];
    }
}