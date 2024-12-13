<?php
function dd($value){
    echo '<pre>';
    echo var_dump($value);
    echo '</pre>';
    die();
}

function register($name,$email,$password){
    $_SESSION['user'] = [
        'name' => $name,
        'email' => $email,
        'password' => $password
    ] ;
    return ;
}


?>