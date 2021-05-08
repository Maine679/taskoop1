<?php
session_start();

require_once "..\class\Input.php";
require_once "..\class\Validate.php";
require_once "..\class\Token.php";
require_once "..\class\Users.php";
require_once "..\class\Redirect.php";

require_once "..\configuration.php";



if(Input::exists(Input::GET)) {

    if(Token::Check($_GET['token'])) {
        $name = Input::get('username', Input::GET);
        Input::set('username', $name);

        $res = Validate::Check($_GET,
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

        if($res) {
            $user = new Users();
            $user->create(
                [
                    'name' => Input::get('username'),
                    'password' => password_hash(Input::get('password'),PASSWORD_DEFAULT)
                ]
            );

            Session::flash('success','Форма отправлена успешно.');
        }

    } else {
        $_SESSION['error'] = ["Найдена попытка подделки сессии."];
    }
}

Redirect::to('..\index.php');























