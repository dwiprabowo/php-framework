<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Auth_Controller{

    function __construct(){
        parent::__construct();
    }

    function index(){
        $this->_var(
            'users_count', 
            [
                'total' => $this->user_model->count_all(),
                'active' => $this->user_model->count_by(['active' => 1]),
                'inactive' => $this->user_model->count_by(['active' => 0]),
            ]
        );
        $this->_var('master_count', 
            [
                'total' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_MASTER
                ]),
                'active' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_MASTER, 'active' => 1
                ]),
                'inactive' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_MASTER, 'active' => 0
                ]),
            ]
        );
        $this->_var('admin_count', 
            [
                'total' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_ADMIN
                ]),
                'active' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_ADMIN, 'active' => 1
                ]),
                'inactive' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_ADMIN, 'active' => 0
                ]),
            ]
        );
        $this->_var('user_count', 
            [
                'total' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_USER
                ]),
                'active' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_USER, 'active' => 1
                ]),
                'inactive' => $this->user_model->count_by([
                    'role' => User_Model::ROLE_USER, 'active' => 0
                ]),
            ]
        );
    }

    function _models(){
        return ['login', 'user'];
    }
}