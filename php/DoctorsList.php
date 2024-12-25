<?php
include_once '../php/connection.php';

if(isset($_POST['speciality'])){
    $speciality = $_POST['speciality'];
    $doctors = getDoctorsBySpecialty($conn, $speciality);
}

function getDoctorsBySpecialty($conn,$speciality)
{
    try {
        $sql = "SELECT * FROM doctor_info WHERE spatiality = '$speciality'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if(isset( $_GET['specialty'])) {
    echo "yeahhh";
    $specialty= $_GET['specialty'];
    $doctors = getDoctorsBySpecialty($conn, $specialty);

}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="../css/DocCards.css" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light grey background */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }

        .speciality-label {
            font-size: 2.5rem;
            color: #333;
            font-weight: bold;
            margin-top: 30px;
            text-align: center;
        }

        .label-underline {
            width: 80%; /* Line reaches 10% from the edges */
            margin: 10px auto;
            border: 0;
            height: 2px;
            background-color: #007bff; /* Blue color for the underline */
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Three cards per row */
            gap: 30px; /* Increased spacing between cards */
            width: 90%;
            max-width: 1200px;
            margin-top: 20px;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            padding: 25px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #007bff;
        }

        .card-content {
            font-size: 1rem;
            color: #555;
            line-height: 1.5;
        }

        .book-now-btn {
            display: block;
            margin: 20px auto 0 auto;
            padding: 12px 25px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .book-now-btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 900px) {
            .card-container {
                grid-template-columns: repeat(2, 1fr); /* Two cards per row for medium screens */
            }
        }

        @media (max-width: 600px) {
            .card-container {
                grid-template-columns: 1fr; /* One card per row for small screens */
            }
        }
    </style>
</head>

<body>

<div class="speciality-label">Our Speciality</div>
<hr class="label-underline">
<div class="card-container">
    <?php if (!empty($doctors)) : ?>

        <?php foreach ($doctors as $doctor) : ?>

    <div class="card">
        <div class="card-title"><?= htmlspecialchars($doctor['name']) ;?> </div>
        <div class="card-content">
            <?=  'spatiality: '. htmlspecialchars($doctor['spatiality']) ?> <br>
            <?= 'expr_years' . htmlspecialchars($doctor['expr_years']) ?> <br>
            <?= 'Email:' .htmlspecialchars($doctor['email']) ?> <br>
            <?= 'Day Works:' . htmlspecialchars($doctor['day_work']) ?> <br>
        </div>
        <form method="GET" action="appoitmnet.php">
            <input type="hidden" value="<?=$doctor['spatiality'] ?>" name ="speciality">
            <input type="hidden" value="<?= $doctor['doc_no'] ?>" name="id">
            <input type="submit" class="book-now-btn" value="book now">
        </form>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <span>no doctors found</span>
    <?php endif; ?>
</div>
</body>
</html>