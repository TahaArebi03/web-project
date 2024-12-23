<?php

function validationName($name)
{
    if ($name == "" || $name == null) {
        return 'name cannot be empty';
    }

    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        return 'name can only contain letters and spaces';
    }
}

function validationEmail($email)
{
    if ($email == "" || $email == null) {
        return 'email cannot be empty';
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'email is not valid';
    }
}

function validationPassword($password, $passwordConfirm)
{
    if ($password == NULL) {
        return 'password cannot be empty';
    }

    if ($password != $passwordConfirm) {
        return 'passwords do not match';
    }
}




function validatePhone($phone) {
    return !preg_match('/^[0-9]{10,15}$/', $phone) ? "Phone number must be 10-15 digits. " : "";
}

function validateAppointmentDate($appointmentDate) {
    return (empty($appointmentDate) || $appointmentDate < date('Y-m-d')) ? "Invalid appointment date. " : "";
}

function validateAppointmentTime($appointmentTime) {
    return empty($appointmentTime) ? "Appointment time is required. " : "";
}
