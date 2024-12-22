<?php
include_once '../php/connection.php';

session_start();
if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];

    echo "Welcome, " . $name . "!";
    echo "<br>Your Email: " . $email;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link ref="stylesheet" href="../css/app.css">
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
                <option value="evaluation">Evaluation</option>
            </select>

            <label for="notes">Additional Notes:</label>
            <textarea id="notes" name="notes" placeholder="Any special instructions or requests"></textarea>

            <button type="submit">Book Appointment</button>
        </form>
    </div>
</body>

</html>