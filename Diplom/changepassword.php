<?php
require_once 'init.php';
$user = new User;
if (!$user->isLoggedIn()) {
    Redirect::to('login.php');
}

$validate = new Validate;

$validate->check($_POST, ['current_password' => ['required' => true, 'min' => 3],
    'new_password' => ['required' => true, 'min' => 3],
    'new_password_again' => ['required' => true, 'min' => 3, 'matches' => 'new_password']]);

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        if ($validate->passed()) {
            if (password_verify(Input::get('current_password'), $user->data()->password)) {
                $user->update(['password' => password_hash(Input::get('new_password'), PASSWORD_DEFAULT)]);
                Session::flash('success', 'Password changed successfully');
                Redirect::to('index.php');
            }
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
  
  <?php require_once 'includes/nav.php'; ?>

   <div class="container">
     <div class="row">
       <div class="col-md-8">
         <h1>Изменить пароль</h1>

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
               <li><a href="profile.php?id=<?= $user->data()->id; ?>">Изменить профиль</a></li>
           </ul>

           <form action="" class="form" method="post">
           <div class="form-group">
             <label for="current_password">Текущий пароль</label>
             <input type="password" id="current_password" name="current_password" class="form-control">
           </div>
           <div class="form-group">
             <label for="current_password">Новый пароль</label>
             <input type="password" id="current_password" name="new_password" class="form-control">
           </div>
           <div class="form-group">
             <label for="current_password">Повторите новый пароль</label>
             <input type="password" id="current_password" name="new_password_again" class="form-control">
           </div>
               <input type="hidden" name="token" value="<?= Token::generate(); ?>">
           <div class="form-group">
             <button class="btn btn-warning">Изменить</button>
           </div>
         </form>


       </div>
     </div>
   </div>
</body>
</html>