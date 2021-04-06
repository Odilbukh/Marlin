<?php
require_once '../init.php';
$user = new User;

$getUserID = $_GET['id'];
$getUser = new User($getUserID);

$validate = new Validate;
$validate->check($_POST, [
    'username' => [
        'required' => true,
        'min' => 2
    ],
    'status' => [
        'required' => true,
        'min' => 5
    ]
]);

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        if ($validate->passed()) {
            $getUser->update(['username' => Input::get('username'), 'status' => Input::get('status')], $getUserID);
            Session::flash('success', 'Профиль обновлен!');
            Redirect::to('index.php');
        } else {
            $danger = '';
            foreach ($validate->errors() as $error) {
                $danger .= '<li>' . $error . '</li>' . '<br>';
            }
            $danger = rtrim($danger, '<br>');
            Session::flash('danger', $danger);
        }
    }
}
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
     <div class="row">
       <div class="col-md-8">
           <h1>Профиль пользователя - <?= $getUser->data()->username; ?></h1>

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
         <form action="" class="form" method="post">
           <div class="form-group">
             <label for="username">Имя</label>
             <input type="text" id="username" name="username" class="form-control" value="<?= $getUser->data()->username; ?>">
           </div>
           <div class="form-group">
             <label for="status">Статус</label>
             <input type="text" id="status" name="status" class="form-control" value="<?= $getUser->data()->status; ?>">
           </div>
             <input type="hidden" name="token" value="<?= Token::generate(); ?>">
           <div class="form-group">
             <button class="btn btn-warning" type="submit">Обновить</button>
           </div>
         </form>


       </div>
     </div>
   </div>
</body>
</html>