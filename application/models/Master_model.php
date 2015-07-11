<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_model extends CI_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('database_model');
    }

    function step1(){

    }

    function ready(){
        if(
            $this->database_model->ready()
            and
            !$this->database_model->noUser()
        ){
            return true;
        }
        return false;
    }
}