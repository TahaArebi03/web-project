<?php
session_start();
require '../functions.php';
include_once '../php/connection.php';
require '../auth/validations.php';

$errors = [];


function insertUser($conn , $name, $email, $password)
{
    try {
          $sql="INSERT INTO users (u_name ,PASSWORD,phone_number,priv) values('$name','$password','091' , '1')";
          $conn->exec($sql);
          echo "Record insert successfully ";
        return ;
}catch(Exception $e){
    echo $e->getMessage();
}
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // تعريف متغيرات
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $pasword_confirm = $_POST['password_confirm'];

    $errors['name'] = validationName($name);
    $errors['email'] = validationEmail($email);
    $errors['password'] = validationPassword($password ,  $pasword_confirm);

    if( ($errors['name'] === NULL) && ($errors['email'] === NULL) && ($errors['password'] === NULL) ){
        register($name, $email, $password);
        insertUser($conn , $name, $email, $password);
        header("location: ../index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration or Sign Up form in HTML CSS | CodingLab</title>
    <link rel="stylesheet" href="../css/signup.css" />
  </head>
  <style>
      .red {
          color: red;
          margin-bottom: 10px;
      }
      .border-red {
          border: 1px solid red;
      }
  </style>
  <body>
    <div class="wrapper">
      <h2>Registration</h2>
      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="input-box">
          <input type="text" placeholder="Enter your name" name="name"
           class="<?php if(isset($errors['name'])): ?>  <?php endif; ?>"  required>
            <?php
            if(isset($errors['name']) ):?>
               <p class = 'red'> <?= $errors['name'] ?> </p>
            <?php
            endif;
            ?>
        </div>
        <div class="input-box">
          <input type="text" placeholder="Enter your email" name="email"
                 class="<?php if(isset($errors['email'])): ?>  <?php endif; ?>"
                 required />
            <?php
            if(isset($errors['email']) ):?>
                <p class = 'red'> <?= $errors['email'] ?> </p>
            <?php
            endif;
            ?>
        </div>
         <div class="input-box">
          <input type="password" placeholder="Create password" name="password"  class="<?php if(isset($errors['password'])): ?>  <?php endif; ?>"required />
        </div>
        <div class="input-box">
          <input type="password" placeholder="Confirm password" name="password_confirm"  class="<?php if(isset($errors['password'])): ?>  <?php endif; ?>"required />
        </div>
          <?php
          if(isset($errors['password']) ):?>
              <p class = 'red'> <?= $errors['password'] ?> </p>
          <?php
          endif;
          ?>
        <div class="policy">
          <input type="checkbox" />
          <h3>I accept all terms & condition</h3>
        </div>
        <div class="input-box button">
          <input type="Submit" value="Register Now" />
        </div>
        <div class="text">
          <h3>Already have an account? <a href="#">Login now</a></h3>
        </div>
      </form>
    </div>
  </body>
</html>
