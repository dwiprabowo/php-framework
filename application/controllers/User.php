<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Auth_Controller{

    function __construct(){
        parent::__construct();
    }

    function profile_post(){
        $this->validate->setRules([
            'fullname ~ Full Name ~ required',
        ]);
        if(!$this->validate->run()){
            $this->notif->add('Please fix form');
        }
    }
}