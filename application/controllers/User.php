<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Auth_Controller{

    function profile_post(){
        $this->validate->setRules([
            'fullname ~ Full Name ~ required|alpha_space|autocorrect[name]',
            'gender ~ Gender ~ required',
            'birth_date ~ Birth Date ~ required|valid_date',
            'birth_place ~ Birth Place ~ required',
            'email ~ Email ~ required|valid_email|autocorrect[email]',
            'phone ~ Phone ~ required',
            'occupation ~ Occupation ~ required',
            'address ~ Address ~ required',
        ]);
        if(!$this->validate->run()){
            notif('message_form_input_error', false);
        }else{

        }
    }
}