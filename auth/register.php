<?php
session_start();
require '../php/functions.php';
include_once '../php/connection.php';
require '../auth/validations.php';

$nameErr = $phoneErr =  $passwordErr = "";

function insertUser($conn, $name, $email, $password)
{
  try {
    $sql = "INSERT INTO users (u_name ,PASSWORD,email,priv) values('$name','$password','$email' , '1')";
    $conn->exec($sql);
    echo "Record insert successfully ";
    return;
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // تعريف متغيرات
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $pasword_confirm = $_POST['password_confirm'];

  $nameErr = validationName($name);
  $emailErr = validationEmail($email);
  $passwordErr = validationPassword($password,  $pasword_confirm);

  if (empty($nameErr) && empty($emailErr) && empty($passwordErr)) {

    register($name, $email, $password);
    insertUser($conn, $name, $email, $password);

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

</style>

<body>
  <div class="wrapper">
    <h2>Registration</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <div class="input-box">
        <input type="text" placeholder="Enter your name" name="name"
          class="<?php if (isset($nameErr)): ?>  <?php endif; ?>" required>
        <?php
        if (isset($nameErr)): ?>
          <p class='red'> <?= $nameErr ?> </p>
        <?php
        endif;
        ?>
      </div>
        <br>
        <div class="input-box">
            <label>Email</label>
            <input type="email" name="email"  required>
            <?php if (isset($errors['email'])): ?>
                <div class="error"><?php echo $errors['email']; ?></div>
            <?php endif; ?>
        </div>
        <br>

      <div class="input-box">
        <input type="password" placeholder="Create password" name="password"  required />
      </div>

      <div class="input-box">
        <input type="password" placeholder="Confirm password" name="password_confirm"  required />
      </div>
      <?php
      if (isset($passwordErr)): ?>
        <p class='red'> <?= $passwordErr ?> </p>
      <?php
      endif;
      ?>
        <br>

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