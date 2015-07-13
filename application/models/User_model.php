<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends MY_Model{

    function getProfilePicture($id){
        $result = $this->get($id);
        if($result){
            $profile_picture = $result->profile_picture;
            if($profile_picture){
                return $profile_picture;
            }
        }
        return 'assets/img/profile-picture-default.png';
    }

    function login($email, $password){
        return $this->get_by([
            'email' => $email,
            'password' => md5($password),
        ]);
    }
}