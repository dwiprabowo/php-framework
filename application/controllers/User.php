<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Auth_Controller{

    function profile_post(){
        $this->validate->setRules([
            'fullname ~ required|alpha_space|autocorrect[name]',
            'gender ~ required',
            'birth_date ~ required|valid_date',
            'birth_place ~ required',
            'email ~ required|valid_email|autocorrect[email]',
            'phone ~ required',
            'occupation ~ required',
            'address ~ required',
        ]);
        if(!$this->validate->run()){
            notif('message_form_input_error', false);
        }else{

        }
    }
}