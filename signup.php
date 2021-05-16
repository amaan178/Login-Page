<?php

require_once 'app/init.php';
if(!empty($_POST))
{
    $validator->check($_POST, [
        'email' => [
            'required' => true,
            'maxlength' => 200,
            'email' => true,
            'unique' => 'users'
        ],
        'username' => [
            'required' => true,
            'maxlength' => 200,
            'minlength' => 3,
            'unique' => 'users'
        ],
        'password' => [
            'required' => true,
            'minlength' => 8,
            'maxlength' => 255
        ]
    ]);

    if($validator->fails()) {
        print_r($validator->errors()->all());
    } else {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $created = $auth->create([
            'email' => $email,
            'username' => $username,
            'password' => $password
        ]);

        if($created) {
            header("Location: index.php");
        } else {
            echo "There was some issue while creating your user!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
    <!-- <h1>Sign Up</h1>
    <form action="signup.php" method = "POST">
        <fieldset>
            <legend>Sign Up</legend>
            <label>Email
                <input type="email" name="email">
                
            </label>
            <br>
            <br>
            <label>Username
                <input type="text" name="username">
            </label>
            <br>
            <br>
            <label>Password
                <input type="password" name="password">
            </label>
            <br>
            <br>
            <input type="submit" value = "Sign Up">
        </fieldset>
    </form> -->
    <div class="row">
        <div class="col-md-6 mx-auto p-0">
            <div class="card">
                <div class="login-box">
                    <form action="signup.php" method="POST">
                        <div class="login-snip">
                            <form action="signin.php" method="POST">
                                <label for="tab-1" class="tab active">Sign Up</label>
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
                                            <label for="pass" class="label">Email Address</label>
                                            <input id="pass" type="email" class="input" name="email"
                                                placeholder="Enter your email address">
                                            <?php
                                            if($validator->fails() && $validator->errors()->has('email')) {
                                                echo $validator->errors()->first('email');
                                            }
                                        ?>
                                        </div>
                                        <div class="group">
                                            <input type="submit" class="button" name="submit" value="Sign Up">
                                        </div>
                                        <div class="hr"></div>
                                        <div class="foot"> <label for="tab-1"><a href="signin.php"> Already Member?</a></label> </div>
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