<?php
require_once "init.php";

if (Validate::is_error()) {
    Validate::show_error();
} else {
    echo Session::flash('success');
}

$user = new Users();

if($user->IsLoggedIn()) {
    echo "Hi, " . $user->Data()[0]->name . ", for logout click <a href='logout.php'>logout</a>";
    echo "<div>Update user info <a href='update.php'>Update</a></div>";
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












