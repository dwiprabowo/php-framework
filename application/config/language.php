<?php
defined('BASEPATH') or exit('No direct script access allowed');

define('LANG_TABLE_LANGUAGE_NAME', 0);
define('LANG_TABLE_COUNTRY_NAME', 1);

$config['available_languages'] = [
    'indonesian' => [
        'default' => true,
        'code' => 'id-id',
        'dir-code' => 'id',
        'icon' => 'id',
    ],
    'english' => [
        'code' => 'en-us',
        'dir-code' => 'us',
        'icon' => 'us',
    ],
];

$enabled_lang = unserialize(PROJECT_ENABLED_LANG);

foreach($enabled_lang as $lang){
    $config['available_languages'][$lang]['enabled'] = true;
}

foreach($config['available_languages'] as $k => $v){
    if(!@$v['enabled']){
        unset($config['available_languages'][$k]);
    }
}

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
