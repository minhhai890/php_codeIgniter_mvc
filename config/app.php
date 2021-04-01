<?php
return [

    'name' => 'CodeIgniter',

    'author' => 'Truong Minh Hai',

    // URL
    'url' => [
        'host' => 'http://localhost/CodeIgniter/',
        'image' => 'http://localhost/CodeIgniter/',
        'publish' => '',
        'logo' => ''
    ],

    // Folder
    'dir' => [
        'config' => DIR_ROOT . 'config' . DS,
        'libs' => DIR_ROOT . 'libs' . DS,
        'src' => DIR_ROOT . 'src' . DS,
        'vendor' => DIR_ROOT . 'vendor' . DS . 'autoload.php'
    ],

    // Database
    'db' => [
        'prefix' => 'tb_',
        'limit' => '12',
        'host' => 'localhost',
        'name' => 'test',
        'username' => 'root',
        'password' => '',
    ]

];
