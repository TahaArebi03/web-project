<?php
include_once '../php/connection.php';
include_once '../auth/validations.php';

session_start();
if (isset($_SESSION['name'])) {
    
    $name = $_SESSION['name'];

    echo "Welcome, " . $name . "!";
   
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['book'])){
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];
    $serviceType = $_POST['serviceType'];
    $notes = $_POST['notes'];


 
    //validate the data
    $fullNameErr = validateFullName($fullName);
    $emailErr = validateEmail($email);
    $phoneErr = validatePhone($phone);
    $appointmentDateErr = validateAppointmentDate($appointmentDate);
    $appointmentTimeErr = validateAppointmentTime($appointmentTime);


    if($fullNameErr || $emailErr || $phoneErr || $appointmentDateErr || $appointmentTimeErr){
        echo "Error: " . $fullNameErr . $emailErr . $phoneErr . $appointmentDateErr . $appointmentTimeErr;
    }
    else{
        $check_Date= "SELECT * FROM appointments WHERE appointmentDate = :appointmentDate AND appointmentTime = :appointmentTime";
        $check_stmt = $conn->prepare($check_Date);
        $check_stmt->execute([':appointmentDate' => $appointmentDate, ':appointmentTime' => $appointmentTime]);
    
        if ($check_stmt->rowCount() > 0) {
            echo "This appointment slot is already taken. Please select another time.";
            exit;
        }
        echo "Appointment booked successfully";
    }   

    //insert the data into the database
    try{
        $insert_query = "INSERT INTO appointments (fullName, email, phone, appointmentDate, appointmentTime, serviceType, notes) VALUES (:fullName, :email, :phone, :appointmentDate, :appointmentTime, :serviceType, :notes)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bindParam(':fullName', $fullName);
        $insert_stmt->bindParam(':email', $email);
        $insert_stmt->bindParam(':phone', $phone);
        $insert_stmt->bindParam(':appointmentDate', $appointmentDate);
        $insert_stmt->bindParam(':appointmentTime', $appointmentTime);
        $insert_stmt->bindParam(':serviceType', $serviceType);
        $insert_stmt->bindParam(':notes', $notes);
        $insert_stmt->execute();    
    }
    catch(PDOException $e){
        echo "Error inserting appointment: " . $e->getMessage();
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/app.css">
    <title>Document</title>
</head>

<body>
    <div class="form-basin">
        <form action="" method="POST">
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" placeholder="Your Full Name">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Your Email">

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" placeholder="Your Phone Number">

            <label for="appointmentDate">Appointment Date:</label>
            <input type="date" id="appointmentDate" name="appointmentDate">

            <label for="appointmentTime">Appointment Time:</label>
            <input type="time" id="appointmentTime" name="appointmentTime">

            <label for="serviceType">Type of Service:</label>
            <select id="serviceType" name="serviceType">
                <option value="">Select Service</option>
                <option value="consultation">Consultation</option>
                <option value="followUp">Follow-up</option>
            </select>

            <label for="notes">Additional Notes:</label>
            <textarea id="notes" name="notes" placeholder="Any special instructions or requests"></textarea>

            <button type="submit" name="book" value="book">Book Appointment</button>
        </form>
    </div>
</body>

</html>