<?php

require_once "Database.php";



//$db = Database::GetExample()->query('SELECT * FROM users WHERE id>?',['20']);

//['field'=>'id','criterion'=>'like','param'=>'1']
$db = Database::GetExample()->insert('users',['name'=>'testName']);

if(!$db->error()) {
    echo "count row " . $db->countRow() . "<br>";

    $users = $db->result();

    foreach ($users as $user) {
        echo "name " . $user->name . "<br>";
    }

}












