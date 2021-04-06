<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">User Management</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Главная</a>
            </li>
            <?php if ($user->hasPermissions('admin')): ?>
            <li class="nav-item">
                <a class="nav-link" href="users/index.php">Управление пользователями</a>
            </li>
            <?php endif; ?>
        </ul>
        <?php if (!$user->isLoggedIn()): ?>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="login.php" class="nav-link">Войти</a>
                </li>
                <li class="nav-item">
                    <a href="register.php" class="nav-link">Регистрация</a>
                </li>
            </ul>
        <?php else: ?>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="profile.php?id=<?= $user->data()->id;?>" class="nav-link">Профиль</a>
            </li>
            <li class="nav-item">
            <a href="logout.php" class="nav-link">Выйти</a>
            </li>
        </ul>
        <?php endif; ?>
    </div>
</nav>
