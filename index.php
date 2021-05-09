<?php
session_start();
require_once "init.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        Проверка валидации
    </title>
    <meta name="description" content="validation">

</head>
<body>
    <div>
        <?
        if(Validate::is_error()) {
            Validate::show_error();
        } else {
            echo Session::flash('success');
        }
        ?>
    </div>

    <form action="action/action.php" method="get">
        <div>
            <label for="username">username</label>
            <input type="text" id="username" name="username" value="<? echo Input::get('username',Input::SESSION); ?>">
        </div>
        <div>
            <label for="email">email</label>
            <input type="email" id="email" name="email" value="<? echo Input::get('email',Input::SESSION); ?>">
        </div>
        <div>
            <label for="password">password</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <label for="password_confirm">password again</label>
            <input type="password" id="password_confirm" name="password_confirm">
            <input hidden="hidden" type="password" id="token" name="token" value="<? echo Token::Generate(); ?>">
        </div>
        <div>
            <button type="submit">Зарегистрироваться</button>
        </div>

    </form>

</body>
</html>


