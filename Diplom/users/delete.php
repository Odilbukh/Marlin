<?php
require_once "../init.php";

$user = new User;
if (!$user->isLoggedIn()) {
    if (!$user->hasPermissions('admin')) {
        Redirect::to('../index.php');
    }
}

$getUserID = $_GET['id'];
Database::getInstance()->delete('users', ['id', '=', $getUserID])->first();

Redirect::to('index.php');