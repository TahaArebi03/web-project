<?php

include_once 'php/connection.php';
include_once 'auth/validations.php';
include_once 'php/functions.php';
session_start();
if(isset($_SESSION['user']['email'])){
    $email = $_SESSION['user']['email'];

    $res = getRes($conn, $email);
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    deleteRes($conn, $id);
}

function deleteRes($conn, $id)
{
    try {
        $query = "DELETE FROM res_info WHERE r_no = '$id'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
    }    catch (PDOException $e) {
        return $e->getMessage();
    }
}
function getPatienByEmail($conn, $email)
{
    try {
        $query = "SELECT * FROM `patient_info` WHERE `email` = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
function getRes($conn, $email)
{
    try {
        $query = "
        SELECT 
            res_info.r_no,
            res_info.date, 
            res_info.type, 
            res_info.d_no, 
            patient_info.name AS patient_name, 
            patient_info.gender, 
            patient_info.tel
        FROM 
            res_info 
        JOIN 
            patient_info 
        ON 
            res_info.u_no = patient_info.u_no
        WHERE 
            patient_info.email = :email
        ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$results) {
            echo "No results found for u_no: $u_no";
        }
        return $results;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();

        return [];
    }
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/home.css" />
    <title>Document</title>
</head>
<style>

    .container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 20px;
        justify-content: center;
    }
    .box {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        width: 300px; /* زيادة العرض */
        background-color: #fdfdfd; /* لون أفتح */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .box p {
        margin: 8px 0; /* زيادة المسافات بين العناصر */
        font-size: 1rem; /* تحسين الحجم */
        color: #444; /* لون النص */
    }

    .box p strong {
        color: #222; /* لون أغمق للنص الأساسي */
    }

    .delete-btn {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 15px;
        background-color: #ff4d4d; /* لون أحمر */
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: background-color 0.3s ease;
    }

    .delete-btn:hover {
        background-color: #e60000; /* لون أغمق عند التمرير */
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 20px;
        justify-content: center;
    }

</style>
<body>
<header class="header">
    <nav class="navbar">
        <div class="logo">
            <a href="#">E-Hospital</a>
        </div>
        <input type="checkbox" id="menu-toggle" />
        <label for="menu-toggle" id="hamburger-btn">&#9776;</label>
        <ul class="links">
            <li><a href="index.php">Home</a></li>
            <li><a href="res.php">Booking</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
        <div class="buttons">
            <?php if(isset($_SESSION['user']['userName'])): ?>
                <a href="auth/logout.php" class="login">Logout</a>
            <?php else: ?>
                <a href="auth/login.php" class="login">Log In</a>
                <a href="auth/register.php" class="signup">Sign Up</a>
            <?php endif; ?>
        </div>

    </nav>
</header>
<?php if(isset($_SESSION['user']['userName'])): ?>
    <div class="container" style="margin-top: 120px;">
        <?php foreach ($res as $item): ?>
            <div class="box">
                <p><strong>Date:</strong> <?= htmlspecialchars($item['date']) ?></p>
                <p><strong>Type:</strong> <?= htmlspecialchars($item['type']) ?></p>
                <p><strong>Doctor ID:</strong> <?= htmlspecialchars($item['d_no']) ?></p>
                <p><strong>Patient Name:</strong> <?= htmlspecialchars($item['patient_name']) ?></p>
                <p><strong>Gender:</strong> <?= htmlspecialchars($item['gender']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($item['tel']) ?></p>
                <form action="<?=  $_SERVER['PHP_SELF'];?>" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($item['r_no']) ?>">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div>
        <a href="auth/login.php" >
            Login
        </a>
    </div>
<?php endif; ?>

</body>
</html>
