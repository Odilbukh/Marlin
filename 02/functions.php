<?php

function get_user_by_email($email)
{
    $dsn = "mysql:host=localhost; dbname=marlin_2";
    $pdo = new PDO($dsn, 'root', 'root');

    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;

}


function add_user($email, $password)
{
    $dsn = "mysql:host=localhost; dbname=marlin_2";
    $pdo = new PDO($dsn, 'root', 'root');


    $sql = 'INSERT INTO users(email, password) VALUES (:email, :password)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);

    return $pdo->lastInsertId();

}

function set_flash_message($key, $message)
{
    $_SESSION['key'] = $key;
    $_SESSION['message'] = $message;
}

function display_flesh_message()
{
if (isset($_SESSION['key'])) {
    echo "<div class=\"alert alert-{$_SESSION['key']} text-dark\" role=\"alert\"> {$_SESSION['message']} </div>";

    unset($_SESSION['message']);
    unset($_SESSION['key']);
    }
}

function redirect_to($path)
{
    header("Location: {$path}");
    exit;
}

function login($email, $password)
{
    $user = get_user_by_email($email);

    if (empty($user))
    {
        return false;
    }
    else
    {
        $check_pass = password_verify($password, $user['password']);
        if ($check_pass == true)
        {
            return $_SESSION['log-in'] = $user;
        }
        else
        {
            return false;
        }
    }
}

function is_log_in()
{
    if (isset($_SESSION['log-in']) && !empty($_SESSION['log-in']))
    {
        return true;
    }
    else
    {
        return false;
    }
}


function is_admin($email)
{

    $user = get_user_by_email($email);

    $role = $user['role'];

    if ($role == 'admin')
    {
        return true;
    }
    else
    {
        return false;
    }
}

function get_users_list()
{
    $dsn = "mysql:host=localhost; dbname=marlin_2";
    $pdo = new PDO($dsn, 'root', 'root');

    $sql = 'SELECT * FROM users';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users_list;
}

function edit_user_info($fullname, $job, $phone, $adres, $user_id)
{
  $dsn = "mysql:host=localhost; dbname=marlin_2";
  $pdo = new PDO($dsn, 'root', 'root');

  $sql = "UPDATE users SET fullname=:fullname, job=:job, phone=:phone, adres=:adres WHERE id =:user_id";
  $stmt= $pdo->prepare($sql);
  $stmt->execute(['fullname' => $fullname, 'job' => $job, 'phone' => $phone, 'adres' => $adres, 'user_id' => $user_id]);
}

function set_status($status, $user_id)
{
  $dsn = "mysql:host=localhost; dbname=marlin_2";
  $pdo = new PDO($dsn, 'root', 'root');

  $sql = "UPDATE users SET status=:status WHERE id =:user_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['status' => $status, 'user_id' => $user_id]);
}

function upload_avatar($avatar, $user_id)
{
    if (!empty($avatar)) {
        $to = 'uploaded/avatar_' . $user_id . '.png';
        move_uploaded_file($avatar, $to);

        $dsn = "mysql:host=localhost; dbname=marlin_2";
        $pdo = new PDO($dsn, 'root', 'root');

        $sql = "UPDATE users SET avatar=:avatar WHERE id =:user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['avatar' => $to, 'user_id' => $user_id]);
    }

}

function set_social_links($vk, $tg, $ins, $user_id)
{
  $dsn = "mysql:host=localhost; dbname=marlin_2";
  $pdo = new PDO($dsn, 'root', 'root');

  $sql = "UPDATE users SET vk=:vk, tg=:tg, ins=:ins WHERE id =:user_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['vk' => $vk, 'tg' => $tg, 'ins' => $ins, 'user_id' => $user_id]);
}

function get_user_by_id($id)
{
    $dsn = "mysql:host=localhost; dbname=marlin_2";
    $pdo = new PDO($dsn, 'root', 'root');

    $sql = "SELECT * FROM users WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id'=>$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function is_author($logged_user_id, $edit_user_id)
{
    if ($logged_user_id !== $edit_user_id)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function edit_credentials($email, $password, $id)
{
    $dsn = "mysql:host=localhost; dbname=marlin_2";
    $pdo = new PDO($dsn, 'root', 'root');

    $sql = "UPDATE users SET email=:email, password=:password WHERE id =:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT), 'id' => $id]);
}

function has_image($id)
{
    $user = get_user_by_id($id);
    if ($user['avatar'] == NULL)
    {
        return false;
    }
    else
    {
        return true;
    }
}