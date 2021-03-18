<?php
session_start();
require_once 'functions.php';

$id = $_SESSION['user_id']['id'];
$fullname = $_POST['fullname'];
$job = $_POST['job'];
$phone = $_POST['phone'];
$adres = $_POST['adres'];

edit_user_info($fullname, $job, $phone, $adres, $id);
set_flash_message('success', 'Профиль успешно обновлен');
redirect_to('users.php');