<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_location_reports extends MY_Migration{

    function fields(){
        return [
            'location_id' => [
                'type' => 'INT',
                'constraint' => 9,
            ],
            'google_user_id' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'desc' => [
                'type' => 'TEXT',
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
        ];
    }
}