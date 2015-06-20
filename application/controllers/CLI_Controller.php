<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class CLI_Controller extends MY_Controller{

    function __construct(){
        parent::__construct();
    }

    function _init(){
        if(!$this->input->is_cli_request()){
            return show_404();
        }
    }
}