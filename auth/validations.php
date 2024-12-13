<?php

function validationName($name)
{
    if($name == "" || $name == null) {
        return 'name cannot be empty';
    }

    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        return 'name can only contain letters and spaces';
    }
}

function validationEmail($email) {
    if($email == "" || $email == null) {
        return 'email cannot be empty';
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'email is not valid';
    }
}

function validationPassword($password , $passwordConfirm) {
    if($password == NULL ) {
        return 'password cannot be empty';
    }

    if($password != $passwordConfirm) {
        return 'passwords do not match';
    }
}