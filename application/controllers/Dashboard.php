<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Auth_Controller{

    function __construct(){
        parent::__construct();
    }

    public function index(){}

    function _models(){
        return ['login'];
    }
}