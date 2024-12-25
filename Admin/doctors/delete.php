<?php

include_once '../../php/connection.php';

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $doctor = getDoctor($conn, $_GET['id']);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['delete'])){
        $id = $_POST['id'];
        if($doctor){
            try{    
                $delete_query = "DELETE FROM doctor_info WHERE doc_no = :id";
                $delete_stmt = $conn->prepare($delete_query);
                $delete_stmt->bindParam(':id', $id);
                $delete_stmt->execute();
                header('Location: ../doctors.php');
            }
            catch(PDOException $e){
                echo "Error deleting doctor: " . $e->getMessage();
            }
        }
        else{
            echo "Doctor not found";
        }
    }
}

function getDoctor($conn, $id)
{
    try {
        $query = "SELECT * FROM `doctor_info` WHERE `doc_no` = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Doctor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f5f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .error {
            color: red;
        }
        .buttons{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .back-btn{
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .delete-btn{
            background-color: red;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>    
</head>
<body>
    <h1>Are you sure you want to delete this doctor?</h1>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $doctor['doc_no']; ?>">
        <input type="submit" name="delete" value="Delete" class="delete-btn">
        <a href="../doctors.php" class="back-btn">Cancel</a>
    </form>

</body>
</html>