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