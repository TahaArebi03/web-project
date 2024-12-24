<?php
require '../../php/functions.php';
include_once '../../php/connection.php';
require '../../auth/validations.php';

$expErr = '';
if (isset($_POST['submit'])) {
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

    // Debugging: Uncomment to check error messages
    // var_dump($nameErr, $emailErr, $specialityErr, $genderErr, $nationalityErr, $dayErr);

    if (empty($nameErr) && empty($emailErr) && empty($specialityErr) && empty($genderErr) && empty($nationalityErr) && empty($dayErr)) {
        $result = insertDoctor($conn, $name, $email, $speciality, $expr_years, $gender, $nationality, $day_work);
        if ($result === true) {
            header("location: index.php");
            exit();
        } else {
            echo "Error: " . $result;
        }
    }
}

function insertDoctor($conn, $name, $email, $speciality, $expr_years, $gender, $nationality, $day_work) {
    try {
        // Corrected column name 'spatiality' in the table
        $query = "INSERT INTO doctor_info (name, email, spatiality, expr_years, gender, nationality, day_work) 
                  VALUES (:name, :email, :speciality, :expr_years, :gender, :nationality, :day_work)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':speciality', $speciality);
        $stmt->bindParam(':expr_years', $expr_years);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':nationality', $nationality);
        $stmt->bindParam(':day_work', $day_work);

        $stmt->execute();
        return true;
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
    <title>Doctor Form</title>
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
</head>
<body>
<div class="form-container">
    <h2>Doctor Details</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
            <?php if (isset($nameErr)) echo '<span class="error">' . $nameErr . '</span>'; ?>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
            <?php if (isset($emailErr)) echo '<span class="error">' . $emailErr . '</span>'; ?>
        </div>
        <div class="form-group">
            <label for="speciality">Speciality:</label>
            <select id="speciality" name="speciality" required>
                <option value="">Select speciality</option>
                <option value="Internal Medicine">Internal Medicine</option>
                <option value="General Surgery">General Surgery</option>
                <option value="Orthopedics">Orthopedics</option>
                <option value="Cardiology">Cardiology</option>
                <option value="Neurology">Neurology</option>
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
            <input type="submit" value="Submit" name="submit">
        </div>
    </form>
</div>
</body>
</html>