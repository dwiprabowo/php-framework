<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends MY_Model{

    function login($email, $password){
        return $this->get_by([
            'email' => $email,
            'password' => md5($password),
        ]);
    }
}