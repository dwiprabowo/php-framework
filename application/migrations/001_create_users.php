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
        ];
    }

}