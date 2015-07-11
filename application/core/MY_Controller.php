<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/REST_Controller.php");
require(APPPATH."controllers/CLI_Controller.php");
require(APPPATH."controllers/Master_Controller.php");
require(APPPATH."controllers/Web_Controller.php");
require(APPPATH."controllers/Auth_Controller.php");

abstract class MY_Controller extends CI_Controller{

    function __construct(){
        parent::__construct();
        foreach ($this->_models() as $key => $value) {
            $this->load->model($value."_model");
        }
    }

    function _models(){return [];}
}
