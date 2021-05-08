<?php
session_start();

require_once "class\Validate.php";
require_once "class\Input.php";

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
        <? Validate::show_error(); ?>
    </div>

    <form action="action/action.php" method="get">
        <div>
            <label for="username">username</label>
            <input type="text" id="username" name="username" value="<? echo Input::get('username',Input::SESSION); ?>">
        </div>
        <div>
            <label for="password">password</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <label for="password_confirm">password again</label>
            <input type="password" id="password_confirm" name="password_confirm">
        </div>
        <div>
            <button type="submit">Зарегистрироваться</button>
        </div>

    </form>

</body>
</html>




<?php




//$db = Database::GetExample()->query('SELECT * FROM users WHERE id>?',['20']);

//['field'=>'id','criterion'=>'like','param'=>'1']
//$db = Database::GetExample()->insert('users',['name'=>'testName']);
//
//if(!$db->error()) {
//    echo "count row " . $db->countRow() . "<br>";
//
//    $users = $db->result();
//
//    foreach ($users as $user) {
//        echo "name " . $user->name . "<br>";
//    }
//
//}

//
//$GLOBALS['config'] = [
//    'mysql' => [
//        'host'=>'localhost',
//        'username'=>'mysql',
//        'password'=>'mysql',
//        'database'=>'task2',
//
//        'something'=> [
//            'no'=> [
//                'foo'=> [
//                    'bar'=>'baz'
//                ]
//            ]
//        ]
//    ],
//    'data' => 'info'
//];
//
//
//echo Config::Get('mysql.something.no.foo.bar',$GLOBALS['config']);


//
//if(Input::exists()) {
//    $validation = new Validate();







?>



































