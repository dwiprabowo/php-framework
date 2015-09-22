<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google_User_Model extends MY_Model{

    protected $before_create = [
        'create_date',
        'update_date',
    ];
    protected $before_update = [
        'update_date',
    ];

    function create_date($data){
        $data['created_date'] = date("Y-m-d H:i:s");
        return $data;
    }

    function update_date($data){
        $data['updated_date'] = date("Y-m-d H:i:s");
        return $data;
    }
}