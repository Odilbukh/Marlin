<?php
session_start();
require_once 'functions.php';

$status = $_POST['status'];
$user_id = $_SESSION['user_data']['id'];
$logged_user = $_SESSION['log-in'];
$is_admin = is_admin($logged_user['email']);

if ( $user_id == $logged_user['id'] || $is_admin == true)
{
    set_status($status, $user_id);
    set_flash_message("success","Профиль успешно обновлен !");
    redirect_to('users.php');
}
else
{
    set_flash_message("danger","Пользователь с этим e-mail уже существует");
    redirect_to('security.php?id='.$user_id);
}