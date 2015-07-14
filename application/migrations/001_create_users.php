<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_users extends MY_Migration{

    function fields(){
        return [
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'keys' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'fullname' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'keys' => true,
            ],
            'birth_date' => [
                'type' => 'DATE',
                'default' => null,
            ],
            'birth_place' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'gender' => [
                'type' => 'CHAR',
                'constraint' => 1,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 18,
            ],
            'occupation' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'address' => [
                'type' => 'TEXT',
            ],
            'profile_picture' => [
                'type' => 'TEXT',
            ],
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'keys' => true,
            ],
            'active' => [
                'type' => 'INT',
                'constraint' => 1,
                'keys' => true,
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