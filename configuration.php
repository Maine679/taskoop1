<?php
//Данные для работы с бд
$GLOBALS['config'] = [
    'mysql' => [
        'host'=>'localhost',
        'username'=>'mysql',
        'password'=>'mysql',
        'database'=>'task2',
    ],
    'session' => [
        'session_token_id' => 'token',
        'session_token' => 'session_token',
        'session_id' => 'session_id'
    ],
    'cookie' => [
        'cookie_name' => 'hash_token',
        'cookie_time' => 86400
    ]
];
