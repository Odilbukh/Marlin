<?php
require_once '../init.php';
$user = new User;

$getUserID = $_GET['id'];
$getUser = new User($getUserID);

if (!$user->isLoggedIn()) {
    if (!$user->hasPermissions('admin')) {
        Redirect::to('../index.php');
    }
}
$edit_user_group = Database::getInstance()->get('users', ['id', '=', $getUserID])->first();

if ($edit_user_group->group_id == 1)
    $user->update(['group_id' => 2], $getUserID);
else
    $user->update(['group_id' => 1], $getUserID);

Redirect::to('index.php');