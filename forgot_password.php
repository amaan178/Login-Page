<?php
require('app/init.php');
if(!empty($_POST))
{
    $email = $_POST['email'];
    $user = $userHelper->findUserByEmail($email);
    if($user)
    {
        $tokenData = $tokenHandler->createForgotPasswordToken($user->id);
        if($tokenData)
        {
            $mail->addAddress($user->email);
            $mail->Subject = "Password Recovery!";
            $mail->Body = "Use this link within 10 minutes to reset the password: <br>";
            $mail->Body .= "<a href = 'http://localhost:9090/reset_password.php?t={$tokenData['token']}'>Reset Password</a>";
            if($mail->send())
            {
                echo "Please check your email to reset your password!";
            }
            else
            {
                echo "Problem sending mail, please try again later!";
            }
        }
        else
        {
            echo "<h3>There is some issue in server, please try again later!";
        }

    }
    else
    {
        echo "<h3>No such email id found!</h3>";
    }
}
else if($auth->check())
{
    echo "<h3>You are already signed in, how can you forget the password!</h3>";
}
else
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <!-- <h1>Forgot Password</h1> -->
    <!-- <form action="forgot_password.php" method="POST">
        <fieldset>
            <legend>Forgot Password</legend>
            <label for="">
                Email: <br>
                <input type="email" name="email">
            </label>
            <br><br>
            <input type="submit" value="Reset Password" name="submit">
        </fieldset>
    </form> -->
    <div class="row">
        <div class="col-md-6 mx-auto p-0">
            <div class="card">
                <div class="login-box">
                     <form action="forgot_password.php" method="POST">
                        <div class="login-snip">
                            <form action="signin.php" method="POST">
                                <label for="tab-1" class="tab active">Reset Password</label>
                                <div class="login-space">
                                    <div class="login">
                                        <div class="group mt-20">
                                            <label for="pass" class="label">Email Address</label>
                                            <input id="pass" type="email" class="input" name="email"
                                                placeholder="Enter your email address">
                                        </div>
                                        <div class="group mt-20">
                                            <input type="submit" class="button" name="submit" value="Reset Password">
                                        </div>
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
}
?>