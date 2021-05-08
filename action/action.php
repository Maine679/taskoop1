<?php
session_start();

require_once "..\class\Input.php";
require_once "..\class\Validate.php";


if(Input::exists(Input::GET)) {
    $name = Input::get('username', Input::GET);
    Input::set('username', $name);

    Validate::Check($_GET,
        [
            'username' => [
                'required' => true,
                'min' => 6,
                'max' => 25,
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























