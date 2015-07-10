<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Database_model extends CI_Model{

    function isReady(){
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
}