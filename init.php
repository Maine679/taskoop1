<?php
session_start();

require_once "class\Validate.php";
require_once "class\Input.php";
require_once "class\Token.php";
require_once "class\Users.php";
require_once "class\Cookie.php";
require_once "configuration.php";
require_once "class\Redirect.php";

if(Cookie::exists(Cookie::getKeyName()) && !Session::exists(Config::Get('session.session_id',$GLOBALS['config']))) {
    $hash = Cookie::get(Cookie::getKeyName());

    $db = Database::GetExample()->select('user_sessions','*',[['field'=>'hash','criterion'=>'=','param'=>$hash]]);

    if($db->countRow()) {
        $user = new Users($db->result()[0]->user_id);
        $user->login();
    }
}




