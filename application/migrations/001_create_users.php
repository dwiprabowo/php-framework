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
            ],
            'birth_place' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'gender' => [
                'type' => 'CHAR',
                'constraint' => 1,
            ],
            'profession' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'address' => [
                'type' => 'TEXT',
            ],
        ];
    }

}