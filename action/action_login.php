<?php
require_once "action.php";

if(Input::exists(Input::GET)) {

    if(Token::Check($_GET['token'])) {
        $email = Input::get('email', Input::ALL);
        Input::set('email', $email);

        $remember = Input::exists(Input::ALL, 'remember');
        if($remember) {
            Input::set('remember','checked');
        }

        $res = Validate::Check($_GET,
            [
                'email' => [
                    'required' => true,
                    'email' => true,
                    'min' => 6,
                    'max' => 255
                ],
                'password' => [
                    'required' => true,
                    'min' => 4
                ],
            ]
        );

        if($res) {
            $user = new Users();
            if($user->login(Input::get('email'), Input::get('password'),$remember)) {


                Token::Generate();
                Session::flash('success','Вы успешно авторизовались.');

                Redirect::to("..\page.php");
                exit();
            } else {
                Session::flash('warning','Неправильный логин или пароль.');
                Redirect::to("..\login.php");
                exit();
            }
        }

    } else {
        $_SESSION['error'] = ["Найдена попытка подделки сессии."];
    }
}



Redirect::to('..\login.php');


