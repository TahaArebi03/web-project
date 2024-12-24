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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/app.css">
    <title>Document</title>

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

        .form-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px 25px;
            width: 300px; /* Smaller width */
        }

        h2 {
            text-align: center;
            margin-bottom: 15px; /* Reduced margin */
            font-size: 1.3rem; /* Slightly smaller font size */
            color: #333;
        }

        .form-group {
            margin-bottom: 12px; /* Reduced spacing between fields */
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="tel"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px; /* Reduced padding */
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem; /* Slightly smaller font size */
            background: #f9f9f9;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        input[type="tel"]:focus,
        input[type="date"]:focus,
        select:focus {
            outline: none;
            border-color: #007bff;
            background: #fff;
        }

        input[type="submit"],
        .back-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        button {
            width: 100%;
            padding: 15px; /* Increased padding for a larger button */
            background-color: #007bff; /* Blue background */
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem; /* Larger font size */
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        input[type="submit"]:hover,
        .back-btn:hover {
            background-color: #0056b3;
        }

        .form-group select {
            appearance: none;
            background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="%23999" d="M2 0L0 2h4z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 10px;
        }

        button {
            width: 50%; /* Both buttons will be equal size */
            padding: 15px;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        button:hover {
            opacity: 0.8; /* Slight opacity on hover for both buttons */
        }

        /* Submit button - Blue background */
        .submit-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        /* Back button - Grey background */
        .back-btn {
            background-color: #808080;
            color: #fff;
            border: none;
        }

        .back-btn:hover {
            background-color: #A9A9A9;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>
<div class="form-container">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <h2>Book Appointment</h2>

        <input type="hidden" name="doc" value="<?= $_GET['id'];?>"  />
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
            <a href="DoctorsList.php" class="back-btn">Back</a>
        </div>
    </form>
</div>
</body>

</html>