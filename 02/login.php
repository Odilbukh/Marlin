<?php
session_start();
require_once 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

$auth = login($email, $password);

if ($auth == false)
{
    set_flash_message('danger', "E-mail и пароль не правильные!");
    redirect_to('page_login.php');
    exit;
}

else
{
    set_flash_message('success', "Добро пожаловать " . $auth['fullname'] . "!");
    redirect_to('users.php');
}
