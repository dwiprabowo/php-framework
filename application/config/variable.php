<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['user_roles'] = [ 
    'master' => 'Master', 
    'admin' => 'Admin', 
    'user' => 'User',
];
$config['user_role_values'] = [
    'master' => 3,
    'admin' => 2,
    'user' => 1,
];
$config['user_role_icon'] = [
    'master' => [
        'fa' => 'user-secret',
        'color' => 'text-danger',
    ],
    'admin' => [
        'fa' => 'user-md',
        'color' => 'text-success',
    ],
    'user' => [
        'fa' => 'user',
        'color' => 'text-muted',
    ],
];