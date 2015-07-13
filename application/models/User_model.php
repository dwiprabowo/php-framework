<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends MY_Model{

    protected $before_create = ['password_hash'];
    protected $before_update = ['password_hash'];

    function password_hash($data){
        if($data){
            change_every($data, 'hash_the_password');
        }
        return $data;
    }

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
}