<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Web_Controller{

    function __construct(){
        parent::__construct();
        if(!$this->login_model->ready()){
            $this->notif->addFlash('Please login!', 'warning');
            redirect('login');
        }
    }

    public function index(){}

    function _models(){
        return ['login'];
    }
}