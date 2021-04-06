<?php
require_once '../init.php';
$user = new User;
 if (!$user->isLoggedIn()) {
     if (!$user->hasPermissions('admin')) {
         Redirect::to('../index.php');
    }
}

$getAll = Database::getInstance()->getAll('users');
$usersList = Database::getInstance()->results();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Users</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
  </head>

  <body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="../index.php">User Management</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                  <a class="nav-link" href="../index.php">Главная</a>
              </li>
              <?php if ($user->hasPermissions('admin')): ?>
                  <li class="nav-item">
                      <a class="nav-link" href="index.php">Управление пользователями</a>
                  </li>
              <?php endif; ?>
          </ul>
          <?php if (!$user->isLoggedIn()): ?>
              <ul class="navbar-nav">
                  <li class="nav-item">
                      <a href="../login.php" class="nav-link">Войти</a>
                  </li>
                  <li class="nav-item">
                      <a href="../register.php" class="nav-link">Регистрация</a>
                  </li>
              </ul>
          <?php else: ?>
              <ul class="navbar-nav">
                  <li class="nav-item">
                      <a href="../profile.php?id=<?= $user->data()->id;?>" class="nav-link">Профиль</a>
                  </li>
                  <li class="nav-item">
                      <a href="../logout.php" class="nav-link">Выйти</a>
                  </li>
              </ul>
          <?php endif; ?>
      </div>
  </nav>

    <div class="container">
      <div class="col-md-12">
        <h1>Пользователи</h1>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Имя</th>
              <th>Email</th>
              <th>Действия</th>
            </tr>
          </thead>

          <tbody>
          <?php foreach ($usersList as $user): ?>
            <tr>
              <td><?= $user->id; ?></td>
              <td><?= $user->username; ?></td>
              <td><?= $user->email; ?></td>
              <td>
              	<a href="edit_user_group.php?id=<?=$user->id; ?>" class="btn btn-success"><?= ($user->group_id == 1) ? 'Назначить администратором' : 'Разжаловать'; ?></a>
                <a href="../user_profile.php?id=<?=$user->id; ?>" class="btn btn-info">Посмотреть</a>
                <a href="edit.php?id=<?=$user->id;?>" class="btn btn-warning">Редактировать</a>
                <a href="delete.php?id=<?=$user->id;?>" class="btn btn-danger" onclick="return confirm('Вы уверены?');">Удалить</a>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>  
  </body>
</html>
