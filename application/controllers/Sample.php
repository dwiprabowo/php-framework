<?php
defined('BASEPATH') or exit('No direct access script allowed');

class Sample extends Web_Controller{

    function __construct(){
        parent::__construct();
    }

    function index(){
        $this->notif->addFlash('from sample');
        redirect('login');
    }
}