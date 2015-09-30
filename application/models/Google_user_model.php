<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google_User_Model extends MY_Model{

    protected $has_many = ['location'];

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

    function get_data(){
        $query = "SELECT 
                google_users.id, COUNT(locations.id) pending_locations
            FROM
                google_users
                    RIGHT JOIN
                locations ON locations.google_user_id = google_users.id
            WHERE
                locations.review_status = 0
            GROUP BY google_users.id
            ORDER BY locations.created_date DESC
        ";
        $result = $this->db->query($query);
        $users = $result->result_array();
        if($users){
            foreach ($users as $index => &$user) {
                $data = @$this->get($user['id'])->data;
                if($data){
                    $user['detail'] = json_decode($data);
                }
            }
        }
        return $users;
    }
}