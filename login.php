<?php
session_start();
require_once "init.php";

$user = new Users();
if($user->IsLoggedIn())
    Redirect::to('page.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        Страница авторизации
    </title>
    <meta name="description" content="validation">

</head>
<body>
<div>
    <?
    if(Validate::is_error()) {
        Validate::show_error();
    } else {
        echo Session::flash('warning');
        echo Session::flash('success');
    }
    ?>
</div>

<form action="action/action_login.php" method="get">

    <div>
        <label for="email">email</label>
        <input type="email" id="email" name="email" value="<? echo Input::get('email',Input::SESSION); ?>">
    </div>
    <div>
        <label for="password">password</label>
        <input type="password" id="password" name="password">
        <input hidden="hidden" type="password" id="token" name="token" value="<? echo Token::Generate(); ?>">
    </div>
    <div>
        <input type="checkbox" id="checkbox" name="remember" <? if(Input::exists(Input::SESSION,'remember')) : ?> checked="checked"<? Session::delete('remember'); endif; ?>>
        <label for="">Запомнить меня</label>
    </div>
    <div>
        <button type="submit">Авторизоваться</button>
    </div>

</form>

</body>
</html>





