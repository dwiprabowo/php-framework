<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CLI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->library('migration');
    }

    public function index(){
        $this->migration->latest();
    }

    public function version($number = false){
        if($number){
            $number = intval($number);
        }
        if($number === false){
            d("Please provide version number");
        }else{
            $this->migration->version($number);
        }
    }
}