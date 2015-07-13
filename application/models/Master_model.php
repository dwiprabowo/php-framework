<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_model extends CI_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('user_model');
    }

    function dbReady(){
        $query = "  SELECT 
                        table_name AS `table`
                    FROM
                        information_schema.tables
                    WHERE
                        table_schema = DATABASE()";
        $result = $this->db->query($query)->result_array();
        if(
            !$result 
            or 
            (count($result) === 1 and $result[0]['table'] === 'migrations')
        ){
            return false;
        }
        return true;
    }

    function noUser(){
        if(!$this->dbReady()){
            return false;
        }
        $user = $this->user_model->limit(1)->get_all();
        if(!count($user)){
            return true;
        }
        return false;
    }
}