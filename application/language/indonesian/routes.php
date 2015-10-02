<?php
defined('BASEPATH') or exit('No direct access script allowed');

$route['mulai'] = 'start';
$route['mulai/pengguna'] = 'start/user';
$route['masuk'] = 'login';
$route['keluar'] = 'logout';
$route['dasbor'] = 'dashboard';
$route['profil/pengguna'] = 'user/profile';
$route['password/minta_tautan'] = 'password/request_link';
$route['ganti/password'] = 'user/change_password';
$route['pengguna/tambah_baru'] = 'user/add_new';
$route['daftar/pengguna'] = 'user/lists';
$route['dashboard/data_moderation'] = 'dashboard/data_moderation';
