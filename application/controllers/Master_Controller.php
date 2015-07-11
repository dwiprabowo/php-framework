<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_Controller extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->_init();
    }

    private function _init(){
        $this->path = 
            $this->router->fetch_class().DS.$this->router->fetch_method();
        $this->load->model('master_model');
        $this->load->model('database_model');
        if(
            !$this->master_model->ready()
            and
            in_array($this->path, [
                'start/index',
                'master/create',
            ])
        ){
            if($this->database_model->ready()){
                d('master create');
                redirect('master/create');
            }else{
                d('start');
                redirect('start');
            }
        }
        die;
    }
}