<?php
include_once '../php/connection.php';
require '../php/functions.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $phone = $_POST["phone"];
    $password = $_POST["password"];

    $phoneErr = validateNumber($phone);
    $passwordErr = validatePassword($password);


    if(empty($phoneErr) && empty($passwordErr) ) {
       $log =  login($phone, $password,$conn);
    }


}
?>
<!DOCTYPE html>

<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Popup Login Form Design | CodingNepal</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <link rel="stylesheet" href="../css/login.css">
    </head>
    <style>
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
                    <label>Phone</label>
                    <input type="text" name="phone" class="<?php if (isset($errors['phone'])): ?>  <?php endif; ?>" required>
                    <?php if (isset($errors['phone'])): ?>
                        <div class="error"><?php echo $errors['phone']; ?></div>
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