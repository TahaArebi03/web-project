<?php
include_once 'connection.php';
include_once '../auth/validations.php';
include_once '../php/functions.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (isset($_POST['book'])) {
        // استلام البيانات من النموذج
        $name = $_POST['Name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $appointmentDate = $_POST['appointmentDate'] ?? '';
        $serviceType = $_POST['serviceType'] ?? '';
        $nationality = $_POST['nationality'] ?? '';
        $gender = $_POST['Gender'] ?? '';
        $doc = $_POST['doc'] ?? '';


        // التحقق من القيم المطلوبة
        if (empty($name) || empty($email) || empty($phone) || empty($appointmentDate) || empty($serviceType) || empty($gender) || empty($doc)) {
            echo "All fields are required!";
            exit();
        }
        $rows = checkRows($conn, $appointmentDate, $doc);

        $rowsNumber = count($rows);
        if($rowsNumber < 10 ) {
            try {
                // إدخال بيانات المريض
                insertPatients($conn, $name, $email, $phone, $gender, $nationality);
                $lastId = $conn->lastInsertId();

                // إدخال بيانات الحجز
                insertRes($conn, $doc, $lastId, $serviceType, $appointmentDate);

                // إعادة التوجيه إلى الصفحة الرئيسية
                header('Location: ../index.php');
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        else{
            echo "this date is not available!";
            header('Location: DoctorsList.php');
            exit();
        }
    }
}

// إدخال بيانات المريض
function insertPatients($conn, $name, $email, $phone, $gender, $nationality)
{
    try {
        $sql = "INSERT INTO patient_info (name, email, tel, gender, nationality) 
                VALUES (:name, :email, :tel, :gender, :nationality)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':tel', $phone);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':nationality', $nationality);
        $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception("Error inserting patient: " . $e->getMessage());
    }
}

// إدخال بيانات الحجز
function insertRes($conn, $doc, $lastId, $serviceType, $appointmentDate)
{
    try {
        $query = "INSERT INTO res_info (u_no, d_no, date, type) 
                  VALUES (:u_no, :d_no, :date, :type)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':u_no', $lastId);
        $stmt->bindParam(':d_no', $doc);
        $stmt->bindParam(':date', $appointmentDate);
        $stmt->bindParam(':type', $serviceType);
        $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception("Error inserting appointment: " . $e->getMessage());
    }
}


function checkRows($conn,$appointmentDate,$doc){
    try {
        $query = "SELECT * FROM res_info WHERE d_no = :d_no AND date = :date";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':d_no', $doc);
        $stmt->bindParam(':date', $appointmentDate);
        $stmt->execute();
        $row = $stmt->fetchall();
        return $row;
    }catch (PDOException $e) {
        echo $e->getMessage();
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

    <style>
        /* General body styling */
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

        /* Error messages */
        .error {
            color: red;
            font-size: 0.9em;
        }

        /* Form container styling */
        .form-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px 25px;
            width: 100%;
            max-width: 400px; /* Ensures the form doesn't stretch too wide */
        }

        /* Form heading */
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #333;
        }

        /* Form group styling */
        .form-group {
            margin-bottom: 15px;
        }

        /* Label styling */
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        /* Input and select styling */
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            background: #f9f9f9;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        input[type="date"]:focus,
        select:focus {
            outline: none;
            border-color: #007bff;
            background: #fff;
        }

        /* Buttons container */
        .buttons {
            display: flex;
            justify-content: space-between;
            gap: 10px; /* Small gap between buttons */
        }

        /* Button styling */
        button,
        .back-btn {
            flex: 1; /* Ensures both buttons have equal width */
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
        }

        button:hover,
        .back-btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px); /* Slight hover effect */
        }

        .back-btn {
            background-color: #6c757d;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
<div class="form-container">
    <h2>Book Appointment</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
        <input type="hidden" name="doc" value= "<?= $_GET['id'];?>" >
        <div class="form-group">
            <label for="Name">Name:</label>
            <input type="text" id="fullName" name="Name" placeholder="Your Full Name" >
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Your Email" value="<?= $_SESSION['user']['email'] ?>">
        </div>

        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" placeholder="Your Phone Number">
        </div>

        <div class="form-group">
            <label for="appointmentDate">Appointment Date:</label>
            <input type="date" id="appointmentDate" name="appointmentDate">
        </div>

        <div class="form-group">
            <label for="nationality">Nationality:</label>
            <input type="text" id="nationality" name="nationality">
        </div>

        <div class="form-group">
            <label for="Gender">Gender:</label>
            <select id="Gender" name="Gender">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="serviceType">Type of Service:</label>
            <select id="serviceType" name="serviceType">
                <option value="">Select Service</option>
                <option value="examination">Consultation</option>
                <option value="review">Review</option>
            </select>
        </div>

        <div class="form-group buttons">

            <button type="submit" name="book" value="book" class="submit-btn">Book appoitment</button>

        </div>
    </form>


    <form class="nothing" method="POST" action="DoctorsList.php">
        <input type="hidden" name="speciality" value="<?= $_GET['speciality'];?>" >
        <input type="submit" value="back" />
    </form>
</div>
</body>

</html>