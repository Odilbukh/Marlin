<?php
session_start();
require_once 'functions.php';

$email = $_POST['email'];


get_user_by_email($email);