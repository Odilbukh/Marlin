<?php
session_start();
require_once 'functions.php';

$avatar = $_FILES['avatar']['tmp_name'];
$user_id = $_SESSION['user_data']['id'];
$logged_user = $_SESSION['log-in'];
$is_admin = is_admin($logged_user['email']);

if ( $user_id == $logged_user['id'] || $is_admin == true)
{
    upload_avatar($avatar, $user_id);
    set_flash_message("success","Профиль успешно обновлен !");
    redirect_to('users.php');
}
else
{
    set_flash_message("danger","Пользователь с этим e-mail уже существует");
    redirect_to('media.php?id='.$user_id);
}

