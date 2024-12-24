<?php
function dd($value)
{
    echo '<pre>';
    echo var_dump($value);
    echo '</pre>';
    die();
}

function validateNumber($phone) {
    if(empty($phone)) {
        return 'Phone is Required';
    } else {
        $phone = test_data($phone);

        if(!filter_var($phone , FILTER_VALIDATE_FLOAT) ) {
            return 'Invalid phone number';
        }

        if(strlen($phone) < 6) {
            return 'Phone must be at least 6 characters';
        }
    }
}

function validatePassword($password)
{
    if(empty($password)) {
        return 'Password is Required';
    } else {
        $password = test_data($password);
        if(strlen($password) < 6) {
            return 'Phone must be at least 6 characters';
        }
    }
}

function test_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function login($email, $password, $conn)
{
    try {
        // Prepare the SQL query to fetch the user by username
        $query = 'SELECT * FROM users WHERE email = :email ';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        // Check if user exists
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify the password (assuming passwords are hashed)
            if ($password === $user['PASSWORD']) {
                // Start the session and store user information
                $_SESSION['user'] = [
                    'id' => $user['u_no'],
                    'userName' => $user['u_name'],
                    'email' => $user['email'],
                ];

                if($user['priv'] == 2) {
                    header("location: ../Admin/index.php");
                    exit();
                }
                header("location: ../index.php");
                exit();
            } else {
                return 'Incorrect password.';
            }
        } else {
            return 'User not found.';
        }
    } catch (PDOException $e) {
        return 'Error: ' . $e->getMessage();
    }
}

function logout() {
    // Start the session to access session variables
    session_start();


    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }

    header("Location: ../index.php");
    exit();
}

function validateSpciality($speciality)
{
    if(empty($speciality)) {
        return 'Speciality cant be empty';
    }
}

function validateGender($gender)
{
    if(empty($gender)) {
        return 'The Gender Is Required';
    }
}

function validationNationality($nationality)
{
    if(empty($nationality)) {
        return 'The Nationality Is Required';
    }
}

function validateDay($day)
{
    if (empty($day)) {
        return 'The Day is Required';
    }

    // Check if the provided day is after today
    $currentDate = date('Y-m-d'); // Get today's date
    if (strtotime($day) <= strtotime($currentDate)) {
        return 'The Day must be after today';
    }


}





function register($name, $email, $password)
{
    $_SESSION['user'] = [
        'userName' => $name,
        'email' => $email,
        'password' => $password
    ];
    return ;
}
