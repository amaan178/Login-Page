<?php
require "app/init.php";
if(!empty($_POST))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rememberMe = $_POST['rem'];
    $status = $auth->signin($username, $password);
    if($status)
    {
        if($rememberMe)
        {
            $user = $userHelper->findUserByUsername($username);
            $token = $tokenHandler->createRememberMeToken($user->id);
            setcookie("token", $token['token'], time() + 1800);
        }
        header('Location: index.php');
    }
    else
    {
        echo "WRONG USERNAME/PASSWORD!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css" type="text/css">

</head>

<body>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>

    <?php if(isset($_COOKIE['token']) && $tokenHandler->isValid($_COOKIE['token'], 1)): ?>

    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
            <use xlink:href="#exclamation-triangle-fill" /></svg>
        <div>
              You are already logged in!
        </div>
    </div>

    <?php else: ?>

    <!-- <h1>Login</h1>
    <form action="signin.php" method="POST">
        <fieldset>
            <legend>
                Sign In
            </legend>
            <label>
                Username:
                <input type="text" name="username">
            </label>
            <br>
            <br>
            <label>
                Password:
                <input type="password" name="password">
            </label>
            <br>
            <br>
            <label>
                <input type="checkbox" name="rem" checked> Remember Me
            </label>
            <br>
            <br>
            <input type="submit" name="submit" value="Sign In">
        </fieldset>
    </form> -->

    <div class="row">
        <div class="col-md-6 mx-auto p-0">
            <div class="card">
                <div class="login-box">
                    <div class="login-snip">
                        <form action="signin.php" method="POST">
                            <label for="tab-1" class="tab active">Login</label>
                            <div class="login-space">
                                <div class="login">
                                    <div class="group">
                                        <label for="user" class="label">Username</label>
                                        <input id="user" type="text" name="username" class="input"
                                            placeholder="Enter your username">
                                    </div>
                                    <div class="group">
                                        <label for="pass" class="label">Password</label>
                                        <input id="pass" type="password" name="password" class="input"
                                            data-type="password" placeholder="Enter your password">
                                    </div>
                                    <div class="group">
                                        <input id="check" type="checkbox" name="rem" class="check" checked>
                                        <label for="check">
                                            <span class="icon"></span>
                                            Keep me Signed in
                                        </label>
                                    </div>
                                    <div class="group">
                                        <input type="submit" class="button" name="submit" value="Sign In">
                                    </div>
                                    <div class="hr"></div>
                                    <div class="foot">
                                        <a href="forgot_password.php">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                        </form>
    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'>
    </script>
    <script type='text/javascript'></script>
</body>

</html>