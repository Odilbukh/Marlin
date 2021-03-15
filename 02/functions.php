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
    $_SESSION['key'] = $key;
    $_SESSION['message'] = $message;
}

function display_flesh_message()
{
if (isset($_SESSION['key'])) {
    echo "<div class=\"alert alert-{$_SESSION['key']} text-dark\" role=\"alert\"> {$_SESSION['message']} </div>";

    unset($_SESSION['message']);
    unset($_SESSION['key']);
    }
}

function redirect_to($path)
{
    header("Location: {$path}");
    exit;
}

function login($email, $password)
{
    $user = get_user_by_email($email);

    if (empty($user))
    {
        return false;
    }
    else
    {
        $check_pass = password_verify($password, $user['password']);
        if ($check_pass == true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
