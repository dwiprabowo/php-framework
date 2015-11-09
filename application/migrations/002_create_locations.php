<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_locations extends MY_Migration{

    function fields(){
        return [
            'latitude' => [
                'type' => 'DECIMAL',
                'constraint' => '20,17',
                'default' => 0,
            ],
            'longitude' => [
                'type' => 'DECIMAL',
                'constraint' => '20,17',
                'default' => 0,
            ],
            'google_user_id' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'default' => null,
            ],
            'created_date' => [
                'type' => 'DATETIME',
                'default' => null,
            ],
            'updated_date' => [
                'type' => 'DATETIME',
                'default' => null,
            ],
            'deleted_date' => [
                'type' => 'DATETIME',
                'default' => null,
            ],
            'admin_id' => [
                'type' => 'INT',
                'constraint' => 9,
                'default' => null,
            ],
            'review_status' => [
                'type' => 'INT',
                'constraint' => 1,
                'default' => 0,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'default' => null,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => null,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => null,
            ],
            'open_time' => [
                'type' => 'TIME',
                'default' => null,
            ],
            'close_time' => [
                'type' => 'TIME',
                'default' => null,
            ],
        ];
    }
}