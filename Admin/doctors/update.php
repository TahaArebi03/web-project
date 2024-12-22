<?php
require '../../php/functions.php';
include_once '../../php/connection.php';
require '../../auth/validations.php';

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $doctor = getDoctor($conn, $_GET['id']);
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
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['update'])){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $speciality = $_POST['speciality']; // Match table's 'spatiality' column
        $expr_years = $_POST['expr_years'];
        $gender = $_POST['gender'];
        $nationality = $_POST['nationality'];
        $day_work = $_POST['day_work'];

        // Validation
        $nameErr = validationName($name);
        $emailErr = validationEmail($email);
        $specialityErr = validateSpciality($speciality);
        $genderErr = validateGender($gender);
        $nationalityErr = validationNationality($nationality);
        $dayErr = validateDay($day_work);

        if (empty($nameErr) && empty($emailErr) && empty($specialityErr) && empty($genderErr) && empty($nationalityErr) && empty($dayErr)) {
            $result = updateDoctor($conn , $id , $name, $email, $speciality, $expr_years, $gender, $nationality, $day_work);
            if ($result === true) {
                header("location: index.php");
                exit();
            } else {
                echo "Error: " . $result;
            }
        }
    }
}

function updateDoctor($conn , $id , $name, $email, $speciality, $expr_years, $gender, $nationality, $day_work)
{
    try {
        $query = "UPDATE doctor_info set name = '$name' , email = '$email' , spatiality = '$speciality' , expr_years = '$expr_years' , gender = '$gender' , nationality = '$nationality' , day_work = '$day_work' WHERE doc_no = '$id'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return true ;
    } catch (PDOException $error) {
        echo $error->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

        .buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .buttons a {
            width: 48%;
            background-color: #808080;
        }

        .buttons a:hover {
            width: 48%;
            background-color: #A9A9A9;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" >
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo isset($doctor['name']) ? htmlspecialchars($doctor['name']) : ''; ?>" >
        <?php if (isset($nameErr)) echo '<span class="error">' . $nameErr . '</span>'; ?>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($doctor['email']) ? htmlspecialchars($doctor['email']) : ''; ?>" required>
        <?php if (isset($emailErr)) echo '<span class="error">' . $emailErr . '</span>'; ?>
    </div>
    <div class="form-group">
        <label for="speciality">Speciality:</label>
        <select id="speciality" name="speciality" required>
            <option value="">Select speciality</option>
            <option value="surgery">surgery</option>
            <option value="bones">bones</option>
            <option value="eyes">eyes</option>
            <option value="nerves">nerves</option>
        </select>
        <?php if (isset($specialityErr)) echo '<span class="error">' . $specialityErr . '</span>'; ?>
    </div>
    <div class="form-group">
        <label for="expr_years">Experience Years:</label>
        <input type="number" id="expr_years" name="expr_years" value="<?php echo isset($expr_years) ? htmlspecialchars($expr_years) : ''; ?>" required>
        <?php if (isset($expErr)) echo '<span class="error">' . $expErr . '</span>'; ?>
    </div>
    <div class="form-group">
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="male" <?php echo (isset($gender) && $gender == 'male') ? 'selected' : ''; ?>>Male</option>
            <option value="female" <?php echo (isset($gender) && $gender == 'female') ? 'selected' : ''; ?>>Female</option>
        </select>
        <?php if (isset($genderErr)) echo '<span class="error">' . $genderErr . '</span>'; ?>
    </div>
    <div class="form-group">
        <label for="nationality">Nationality:</label>
        <input type="text" id="nationality" name="nationality" value="<?php echo isset($nationality) ? htmlspecialchars($nationality) : ''; ?>" required>
        <?php if (isset($nationalityErr)) echo '<span class="error">' . $nationalityErr . '</span>'; ?>
    </div>
    <div class="form-group">
        <label for="day_work">Day of Work:</label>
        <input type="date" id="day_work" name="day_work" value="<?php echo isset($day_work) ? htmlspecialchars($day_work) : ''; ?>" required>
        <?php if (isset($dayErr)) echo '<span class="error">' . $dayErr . '</span>'; ?>
    </div>
    <div class="buttons">
        <a href="index.php" class="back-btn">Back</a>
        <input type="submit" value="Submit" name="update">
    </div>
</form>
</body>
</html>
