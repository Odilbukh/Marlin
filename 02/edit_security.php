<?php
session_start();
require_once 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];
$id = $_SESSION['user_data']['id'];

$my_email = $_SESSION['log-in']['email'];

$user = get_user_by_email($email);

if (($user['email'] !== $email) || $my_email !== $user['email'] )
{
    set_flash_message('danger', 'Пользователь с этим e-mail уже существует');
    redirect_to('security.php');
}
else
{
    edit_credentials($email, $password, $id);

    set_flash_message('success', 'Профиль успешно обновлен !');
    redirect_to('users.php');
}


