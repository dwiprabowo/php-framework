<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Auth_Controller{

    function __construct(){
        parent::__construct();
    }

    public function index(){}

    public function index_post(){
        extract($this->input->get_post(null));
        $start = new DateTime($start);
        $end = new DateTime($end);

        $this->_var('interval', date_diff($start, $end));
    }

    function _models(){
        return ['login'];
    }
}