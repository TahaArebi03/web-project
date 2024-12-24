<?php
include_once '../php/connection.php';
require '../php/functions.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $emailErr = validationEmail($email);
    $passwordErr = validatePassword($password);


    if(empty($emailErr) && empty($passwordErr) ) {
       $log =  login($email, $password,$conn);
    }
}

function validationEmail($email)
{
    if ($email == "" || $email == null) {
        return 'email cannot be empty';
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'email is not valid';
    }
}
?>
<!DOCTYPE html>

<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Popup Login Form Design</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <link rel="stylesheet" href="../css/login.css">
    </head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(45deg, #3498db, #8e44ad);
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
        }

        .container {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 400px;
            text-align: center;
            color: #333;
        }

        .container .text {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #444;
        }

        .data label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }

        .data input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .data input:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        .btn {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 40px;
            border-radius: 5px;
            margin-top: 10px;
            background: #3498db;
            text-align: center;
        }

        .btn button {
            position: relative;
            z-index: 1;
            background: none;
            border: none;
            outline: none;
            color: #fff;
            font-size: 16px;
            text-transform: uppercase;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .btn:hover {
            background: #2980b9;
        }

        .error {
            color: red;
            font-size: 12px;
            text-align: left;
            margin-top: -10px;
            margin-bottom: 10px;
        }

        .error {
            color: red;
            margin: 10px auto;
        }
    </style>
<body>
    <div class="center">
        <div class="container">
            <label class="close-btn fas fa-times" title="close"></label>
            <div class="text">
                Login Form
            </div>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <div class="data">
                    <label>Email</label>
                    <input type="email" name="email"  required>
                    <?php if (isset($errors['email'])): ?>
                        <div class="error"><?php echo $errors['email']; ?></div>
                    <?php endif; ?>
                </div>
                <br>
                <div class="data">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                 <?php if (isset($errors['password'])): ?>
                        <div class="error"><?php echo $errors['password']; ?></div>
                    <?php endif; ?>

                <?php if (isset($log)): ?>
                    <div class="error"><?php echo $log; ?></div>
                <?php endif; ?>
                <div class="forgot-pass">
                    <a href="#">Forgot Password?</a>
                </div>
                <div class="btn">
                    <div class="inner"></div>
                    <button type="submit">login</button>
                </div>
                <div class="signup-link">
                    Not a member? <a href="register.php">Signup now</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>