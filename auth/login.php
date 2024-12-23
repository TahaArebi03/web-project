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
        <title>Login Form </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <link rel="stylesheet" href="../css/login.css">
    </head>
    <style>
        /* Base styles for the login page */
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(120deg, #2980b9, #8e44ad);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.center {
    width: 100%;
    max-width: 400px;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.container {
    position: relative;
}

.text {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
    color: #444;
}

.data {
    margin: 10px 0;
}

label {
    font-size: 14px;
    color: #333;
    margin-bottom: 5px;
    display: block;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

input:focus {
    border-color: #2980b9;
    outline: none;
}

.btn {
    margin: 20px 0;
    display: flex;
    justify-content: center;
}

.btn button {
    padding: 10px 20px;
    background: #2980b9;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn button:hover {
    background: #21618c;
}

.forgot-pass {
    margin: 10px 0;
    text-align: center;
}

.forgot-pass a {
    color: #2980b9;
    text-decoration: none;
    font-size: 14px;
}

.signup-link {
    margin-top: 15px;
    text-align: center;
    font-size: 14px;
}

.signup-link a {
    color: #8e44ad;
    text-decoration: none;
    font-weight: bold;
}

/* Responsive Styles */
@media (max-width: 768px) {
    body {
        padding: 10px;
    }

    .center {
        max-width: 90%;
        padding: 20px;
    }

    .text {
        font-size: 20px;
    }

    label {
        font-size: 12px;
    }

    input {
        font-size: 12px;
    }

    .btn button {
        font-size: 14px;
    }

    .forgot-pass a, .signup-link a {
        font-size: 12px;
    }
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