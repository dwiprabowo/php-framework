<?php
defined('BASEPATH') or exit('No direct script access allowed');

define('LANG_TABLE_LANGUAGE_NAME', 0);
define('LANG_TABLE_COUNTRY_NAME', 1);

$config['available_languages'] = [
    'indonesian' => [
        'default' => true,
        'code' => 'id-id',
        'icon' => 'id',
    ],
    'english' => [
        'code' => 'en-us',
        'icon' => 'us',
    ],
];

$config['lang_table'] = [
    'en-US' => [
        'English',
        'United States',
        '0x0409',
        'ENU'
    ],
    'id-ID' => [
        'Indonesian',
        'Indonesia',
        '0x0421',
        false
    ],
];
