<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Auth_Controller{

    function profile_post(){
        $this->validate->setRules([
            'fullname ~ Full Name ~ required|autocorrect[name]',
            'gender ~ Gender ~ required',
            'birth_date ~ Birth Date ~ required',
            'birth_place ~ Birth Place ~ required',
            'email ~ Email ~ required|valid_email',
            'phone ~ Phone ~ required',
            'occupation ~ Occupation ~ required',
            'address ~ Address ~ required',
        ]);
        if(!$this->validate->run()){
            $this->notif->add('Please fix form');
        }else{

        }
    }
}