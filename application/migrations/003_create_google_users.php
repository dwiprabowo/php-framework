<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_google_users extends MY_Migration{

    function fields(){
        return [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'data' => [
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