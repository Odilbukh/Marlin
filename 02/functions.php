<?php

function get_user_by_email($email, $password)
{
    $dsn = "mysql:host=localhost; dbname=marlin_2";
    $pdo = new PDO($dsn, 'root', 'root');

    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array('email' => $email));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result !== false)
    {
        $error_msg = "<strong> Уведомление! </strong> Этот эл. адрес уже занят другим пользователем.";
        $_SESSION['error'] = $error_msg;

        header("Location: ../page_register.php");
        exit;
    }

    else
    {
        add_user($email, $password);
    }

}


function add_user($email, $password)
{
    $dsn = "mysql:host=localhost; dbname=marlin_2";
    $pdo = new PDO($dsn, 'root', 'root');


    $sql = 'INSERT INTO users(email, password) VALUES (:email, :password)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array('email' => $email, 'password' => $password));

    if ($stmt == true) {

        $sql = 'SELECT id FROM users WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array('email' => $email));
        $user_id = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!empty($user_id))
        {
            $success_msg = 'Регистрация прошло успешна!';
            $_SESSION['success'] = $success_msg;

            header("Location: ../page_login.php");
        }

    }
}
