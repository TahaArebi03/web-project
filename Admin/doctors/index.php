<?php
require "../../php/functions.php";
require "../../php/connection.php";

$doctors = getDoctors($conn);

function getDoctors($conn)
{
    try {
        $sql = "SELECT * FROM doctor_info";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Dashboard</title>
    <style>
        .active {
            background-color: #2c3e50;
        }
    </style>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>

<body>
<div class="sidebar">
    <div>
        <h1>Clinic Panel</h1>
        <ul>
            <li><a href="../index.php">Dashboard</a></li>
            <li><a href="index.php" class="active">Doctors</a></li>
            <li><a href="#">Patients</a></li>
        </ul>
    </div>
    <div class="sidebar-footer">
        <a href="../../auth/logout.php">Logout</a>
    </div>
</div>

<div class="main-content">
    <h2>Appointments</h2>
    <a href="addDoctor.php" class="add-button">Add Doctor</a>
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th> Email </th>
            <th>Speciality</th>
            <th>Day_works</th>
            <th> Gender </th>
            <th>Exp Years</th>
            <th>nationality</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($doctors as $doctor) : ?>
        <tr>
            <th> <?= $doctor['name'] ?></th>
            <th> <?= $doctor['email'] ?></th>
            <th> <?= $doctor['spatiality'] ?></th>
            <th> <?= $doctor['gender'] ?></th>
            <th> <?= $doctor['day_work'] ?></th>
            <th> <?= $doctor['expr_years'] ?></th>
            <th> <?= $doctor['nationality'] ?></th>
            <td>
                <div class="action-buttons">
                    <!-- Forms For Edit And Delete -->
                    <form method="GET" action="update.php">
                        <input type="hidden" value="<?= $doctor['doc_no'] ?>" name="id">
                        <input type="submit" value="Update" class="edit-btn">
                    </form>
                    <button class="delete-btn">Delete</button>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
