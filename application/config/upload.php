<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['upload'] = [
    'image' => [
        'upload_path' => FCPATH.'assets/img/upload/',
        'allowed_types' => 'gif|jpg|png|ico',
        'max_size' => 320,
        'max_width' => 1024,
        'max_height' => 768,
    ],
];