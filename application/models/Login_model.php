<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{

    const KEYWORD = 'login';

    function __construct(){
        parent::__construct();
        $this->load->model('user_model');
    }

    function signIn($email, $password){
        $result = $this->user_model->get_by([
            'email' => $email,
            'password' => md5($password),
        ]) and $this->setData($result);
        if(!$result)return false;
        $this->notif->addFlash('Successfully Login!', 'success');
        redirect('dashboard');
    }

    function signOut(){
        $this->deleteData();
        $this->notif->addFlash('Successfully Logout!', 'info');
        redirect('login');
    }

    function ready(){
        $result = $this->session->userdata(self::KEYWORD);
        return $result;
    }

    function setData($user){
        $this->session->set_userdata(
            self::KEYWORD
            , $user->id
        );
    }

    function deleteData(){
        $this->session->unset_userdata(self::KEYWORD);
    }

    function _models(){
        return ['user'];
    }
}