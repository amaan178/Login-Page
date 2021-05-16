<?php
require ("app/init.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    <?php if($auth->check()) : ?>
        <h1>Welcome <?php echo $auth->user()->username;?></h1>
        <p>You are logged in: <a href="signout.php">Sign out</a></p>
    <?php else: ?>
        <p>You are not logged in: <a href="signin.php">Sign IN</a> OR <a href="signup.php">Sign Up</a></p>
    <?php endif; ?>
</body>
</html>