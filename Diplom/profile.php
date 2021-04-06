<?php
require_once 'init.php';
$user = new User;
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
            $user->update(['username' => Input::get('username'), 'status' => Input::get('status')]);
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

<?php require_once "includes/nav.php"; ?>

   <div class="container">
     <div class="row">
       <div class="col-md-8">
         <h1>Профиль пользователя - <?= $user->data()->username; ?></h1>

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

         <ul>
           <li><a href="changepassword.php?id=<?= $user->data()->id; ?>">Изменить пароль</a></li>
         </ul>
         <form action="" class="form" method="post">
           <div class="form-group">
             <label for="username">Имя</label>
             <input type="text" id="username" name="username" class="form-control" value="<?= $user->data()->username; ?>">
           </div>
           <div class="form-group">
             <label for="status">Статус</label>
             <input type="text" id="status" name="status" class="form-control" value="<?= $user->data()->status; ?>">
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