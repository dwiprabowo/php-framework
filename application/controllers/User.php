<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Auth_Controller{

    function __construct(){
        parent::__construct();
    }

    function profile_post(){
        $this->validate->setRules([
            'fullname ~ Full Name ~ required',
            'gender ~ Gender ~ required',
            'birth_date ~ Birth Date ~ required',
            'birth_place ~ Birth Place ~ required',
            'phone ~ Phone ~ required',
            'profession ~ Profession ~ required',
            'address ~ Address ~ required',
        ]);
        if(!$this->validate->run()){
            $this->notif->add('Please fix form');
        }else{
            
        }
    }
}