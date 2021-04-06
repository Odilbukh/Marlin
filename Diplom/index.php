<?php
require_once 'init.php';

$user = new User;
$getAllUsers = Database::getInstance()->getAll('users');
$usersList = Database::getInstance()->results();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <?php require_once 'includes/nav.php'; ?>

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="jumbotron">
          <h1 class="display-4">Привет, мир!</h1>
          <p class="lead">Это дипломный проект по разработке на PHP. На этой странице список наших пользователей.</p>
          <hr class="my-4">
          <p>Чтобы стать частью нашего проекта вы можете пройти регистрацию.</p>
          <a class="btn btn-primary btn-lg" href="register.php" role="button">Зарегистрироваться</a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">

          <?php if (Session::exists('danger')): ?>
              <div class="alert alert-danger">
                  <ul>
                      <?php echo Session::flash('danger'); ?>
                  </ul>
              </div>
          <?php endif;?>

          <?php if (Session::exists('success')): ?>
              <div class="alert alert-success">
                  <?php echo Session::flash('success'); ?>
              </div>
          <?php endif;?>

          <?php if (Session::exists('info')): ?>
              <div class="alert alert-info">
                  <?php echo Session::flash('info'); ?>
              </div>
          <?php endif;?>

        <h1>Пользователи</h1>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Имя</th>
              <th>Email</th>
              <th>Дата</th>
            </tr>
          </thead>

          <tbody>
          <?php foreach ($usersList as $user): ?>
            <tr>
              <td><?= $user->id; ?></td>
              <td><a href="user_profile.php?id=<?= $user->id; ?>"><?= $user->username; ?></a></td>
              <td><?= $user->email; ?></td>
              <td><?= $user->register_data; ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>