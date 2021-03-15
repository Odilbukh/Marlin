<?php

function get_user_by_email($email)
{
    $dsn = "mysql:host=localhost; dbname=marlin_2";
    $pdo = new PDO($dsn, 'root', 'root');

    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;

}


function add_user($email, $password)
{
    $dsn = "mysql:host=localhost; dbname=marlin_2";
    $pdo = new PDO($dsn, 'root', 'root');


    $sql = 'INSERT INTO users(email, password) VALUES (:email, :password)';
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute(['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);

    return $pdo->lastInsertId();

}

function set_flash_message($key, $message)
{
    $_SESSION[$key] = $message;
}

function display_flesh_message($key)
{
if (isset($_SESSION[$key])) {
    echo "<div class=\"alert alert-{$key} text-dark\" role=\"alert\"> {$_SESSION[$key]} </div>";

    unset($_SESSION[$key]);
    }
}

function redirect_to($path)
{
    header("Location: {$path}");
    exit;
}
