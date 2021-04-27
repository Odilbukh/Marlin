<?php $this->layout('layout',['title' => 'User profile', 'auth' => $auth])?>

<div class="row">
    <div class="col-md-12">
        <div class="jumbotron">
            <h1 class="display-4">Привет, мир!</h1>
            <p class="lead">Это дипломный проект по разработке на PHP. На этой странице список наших пользователей.</p>
            <hr class="my-4">
            <?php if(!$auth->isLoggedIn()):?>
                <p>Чтобы стать частью нашего проекта вы можете пройти регистрацию.</p>
                <a class="btn btn-primary btn-lg" href="/register" role="button">Зарегистрироваться</a>
            <?php endif;?>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h1>Пользователи</h1>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($users as $user) :?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><a href="/about?id=<?php echo $user['id']; ?>"><?php echo $user['username']; ?></a></td>
                    <td><?php echo $user['email']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>