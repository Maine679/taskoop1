<?php
session_start();
require_once "init.php";

if (Validate::is_error()) {
    Validate::show_error();
} else {
    echo Session::flash('success');
}

$user = new Users();

if($user->IsLoggedIn()) {
    echo "Hi, " . $user->Data()[0]->name . ", for logout click <a href='logout.php'>logout</a>";
} else {
?>

<div>
    <a href='login.php'>login</a>
</div>
<div>
    <a href='register.php'>register</a>
</div>

<?php
}












