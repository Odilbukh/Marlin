<?php
require_once 'init.php';
$user = new User;
$getUser = Database::getInstance()->get('users', ['id', '=', $_GET['id']])->first();

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
         <h1>Данные пользователя</h1>
         <table class="table">
           <thead>
             <th>ID</th>
             <th>Имя</th>
             <th>Дата регистрации</th>
             <th>Статус</th>
           </thead>

           <tbody>
             <tr>
               <td><?= $getUser->id; ?></td>
               <td><?= $getUser->username; ?></td>
               <td><?= $getUser->register_data; ?></td>
               <td><?= $getUser->status; ?></td>
             </tr>
           </tbody>
         </table>


       </div>
     </div>
   </div>
</body>
</html>