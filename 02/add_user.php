<?php
session_start();
require_once 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

$fullname = $_POST['fullnanme'];
$company = $_POST['company'];
$adres = $_POST['adres'];
$phone = $_POST['phone'];
$status = $_POST['status'];
$avatar = $_FILES['avatar']['tmp_name'];
$vk = $_POST['vk'];
$tg = $_POST['tg'];
$ins = $_POST['ins'];

if(!get_user_by_email($email))
{
  $user_id = add_user($email, $password);

  edit_user_info($fullname, $company, $phone, $adres, $user_id);
  upload_avatar($avatar, $user_id);
  set_social_links($vk, $tg, $ins, $user_id);
  set_status($status, $user_id);

  set_flash_message('success', 'Новый пользователь был добавлен!');
  redirect_to("users.php");
}
else
{
  set_flash_message('danger', 'Пользователь с этим e-mail уже существует');
  redirect_to("create_user.php");
}
