<?php
session_start();

require_once "..\class\Input.php";
require_once "..\class\Validate.php";
//require_once "..\class\Config.php";

//Данные для работы с бд
$GLOBALS['config'] = [
    'mysql' => [
        'host'=>'localhost',
        'username'=>'mysql',
        'password'=>'mysql',
        'database'=>'task2',
    ],
];



if(Input::exists(Input::GET)) {
    $name = Input::get('username', Input::GET);
    Input::set('username', $name);

    Validate::Check($_GET,
        [
            'username' => [
                'required' => true,
                'min' => 6,
                'max' => 255,
                'unique' => 'users'
            ],
            'password' => [
                'required' => true,
                'min' => 4
            ],
            'password_confirm' => [
                'required' => true,
                'matches' => 'password'
            ]
        ]

    );
}

header('Location: ..\index.php');























