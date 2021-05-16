<?php
require "app/init.php";

if($auth->check())
{
    $user = $auth->user();

    $auth->signout();
    //delete the token from database
    $tokenHandler->deleteToken($user->id, 1);
    //clear the token cookie from the browser history
    unset($_COOKIE['token']);
    setcookie('token', '', time()-3600);

    header("Location: index.php");
}
else
{
    echo "Unauthorized access!";
}
?>