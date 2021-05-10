<?php
require_once "init.php";

$user = new Users();
if($user->logout()) {
    Session::flash('success','Вы вышли из системы.');
}
echo Session::flash('success');

