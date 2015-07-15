<?php
defined('BASEPATH') or exit('No direct script access allowed');

abstract class App_Controller extends Web_Controller{

    function __construct(){
        parent::__construct();
        $this->_init();
    }

    function _isLogin(){
        return $this->login_model->ready();
    }

    private function _init(){
        $this->load->model('master_model');
        if($this->uri->uri_string() !== t_uri($this->getPage())){
            if(!$this->input->post(null)){
                redirect($this->getPage());
            }
        }
    }

    private function getPage(){
        if(!$this->master_model->dbReady()){
            return 'start';
        }elseif($this->master_model->noUser()){
            return 'start/user';
        }else{
            if($this->router->fetch_class() === 'start'){
                return PROJECT_LANDING;
            }
            return $this->uri->uri_string();
        }
    }

    function _models(){return ['login'];}
}