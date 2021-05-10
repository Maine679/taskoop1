<?php
require_once "action.php";


$user = new Users();
$user->login();


if(Input::exists(Input::GET) && $user->IsLoggedIn()) {

    if (Token::Check($_GET['token'])) {

        $res = Validate::Check($_GET,
            [
                'username' => [
                    'required' => true,
                    'min' => 6,
                    'max' => 255
                ]
            ]
        );

        if($res) {
            $username = Input::get('username');
            $db = Database::GetExample()->update('users',['name'=>$username],[['field'=>'id','criterion'=>'=','param'=>$user->Data()[0]->id]]);
            if($db->countRow()) {
                Session::flash('success','Данные успешно обновлены.');
            }
        }

    }
}

Redirect::to('../update.php');

