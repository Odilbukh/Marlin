<?php
session_start();
require_once 'functions.php';
$id = $_GET['id'];
$user_data = get_user_by_id($id);
$_SESSION['user_data'] = $user_data;

$user_id = $_SESSION['user_data']['id'];
$logged_user = $_SESSION['log-in'];
$user_avatar = $logged_user['avatar'];
$is_admin = is_admin($logged_user['email']);

if ( $user_id == $logged_user['id'] || $is_admin == true)
{
    delete_user($user_id);
    unlink($_SESSION['user_data']['avatar']);
    if ($user_id == $logged_user['id'])
    {
        session_destroy();
        redirect_to('page_register.php');
    }

    set_flash_message("success","Профиль удалён!");
    redirect_to('users.php');
}
