<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/core/REST_Controller.php");
require(APPPATH."controllers/core/CLI_Controller.php");
require(APPPATH."controllers/core/WebMethod_Controller.php");
require(APPPATH."controllers/core/Web_Controller.php");
require(APPPATH."controllers/core/App_Controller.php");
require(APPPATH."controllers/core/Auth_Controller.php");

abstract class MY_Controller extends CI_Controller{

    function __construct(){
        parent::__construct();
        foreach ($this->_models() as $key => $value) {
            $this->load->model($value."_model");
        }
    }

    function _models(){return [];}
}
