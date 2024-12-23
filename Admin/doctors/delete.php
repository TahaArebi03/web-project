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
                $delete_query = "DELETE FROM 'doctor_info' WHERE 'doc_no' = :id";
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
        $sql = "SELECT * FROM `doctor_info` WHERE `doc_no` = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
?>