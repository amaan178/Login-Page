<?php
require 'app/init.php';
if(!empty($_GET['t']))
{
    $token = $_GET['t'];
    if($token && $tokenHandler->isValid($token,0)):

?>
<!-- <form action="reset_password.php" method="POST">
    <fieldset> 
        <legend>
            <label>
                New Password:
                <input type="password" name="password">
            </label>
            <br> <br>
            <input type="hidden" name="t" value="">
            <input type="submit" value="Reset Password" name="submit">
        </legend>
    </fieldset>
</form> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<div class="row">
        <div class="col-md-6 mx-auto p-0">
            <div class="card">
                <div class="login-box">
                     <form action="reset_password.php" method="POST">
                        <div class="login-snip">
                            <form action="signin.php" method="POST">
                                <label for="tab-1" class="tab active">Reset Password</label>
                                <div class="login-space">
                                    <div class="login">
                                    <div class="group">
                                            <label for="pass" class="label">Password</label>
                                            <input id="pass" type="password" name="password" class="input" data-type="password" placeholder="Enter your New password">
                                        </div>
                                        <div class="group mt-20">
                                            <input type="submit" class="button" name="submit" value="Reset Password">
                                        </div>
                                        <input type="hidden" name="t" value="<?= $token; ?>">
                                        <div class="hr"></div>
                                        <div class="foot"> <label for="tab-1"><a href="signin.php"> Can Remember something?</a></label> </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'>
    </script>
</body>
</html>
<?php
    else: 
        echo "<h3>Invalid Link, please try with authenticated link!</h3>";
    endif;
}
    //WHen i submit the form
else if(!empty($_POST))
{
    $password = $_POST['password'];
    $token = $_POST['t'];
    if($tokenHandler->isValid($token, 0))
    {
        $user = $userHelper->findUserByToken(($token));
        if($auth->updatePassword($user->id, $password))
        {
            $tokenHandler->deleteTokenByToken($token);
            echo "<h3>Password Reset successfully!</h3>";
            echo "<br><a href='signin.php'>Sign In</a>";
        }
        else
        {
            echo "Problem with server while updating password, please try again later";
        }
    }
    else
    {
        echo "Your timeout, please try to generate a new link!";
    }
}
else
{
    echo "<h3>This looks like some fishy activity, we will report it to admin</h3>";
}