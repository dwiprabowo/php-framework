<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('user_model');
    }

    function valid($email, $password){
        $result = $this->user_model->get_by([
            'email' => $email,
            'password' => md5($password),
        ]);
        return $result;
    }
}