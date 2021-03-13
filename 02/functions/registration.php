<?php
session_start();
require_once '../functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

get_user_by_email($email, $password);
