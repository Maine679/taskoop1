<?php

require_once "init.php";


//$user = new Users();
//if($user->IsLoggedIn())
//    Redirect::to('page.php');

if (Validate::is_error()) {
    Validate::show_error();
} else {
    echo Session::flash('success');
    echo Session::flash('warning');
}

$user = new Users();


//    echo "Hi, " . $user->Data()[0]->name . ", <br> ";

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
<? if($user->IsLoggedIn()): ?>
    <form action="action/action_update.php" method="get">

        <div>
            <label for="email">username</label>
            <input type="text" id="username" name="username" value="<? echo $user->Data()[0]->name; ?>">
            <input hidden="hidden" type="password" id="token" name="token" value="<? echo Token::Generate(); ?>">
        </div>
        <div>
            <button type="submit">Изменить</button>
        </div>

    </form>

<? else: ?>

    <div>
        <a href='login.php'>login</a>
    </div>
    <div>
        <a href='register.php'>register</a>
    </div>

<?php endif; ?>


</body>
</html>




