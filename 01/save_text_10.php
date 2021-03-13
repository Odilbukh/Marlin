<?php
session_start();

$text = $_POST['text'];

$pdo =  new PDO('mysql:host=localhost;dbname=marlin', 'root', 'root');

$stmt = $pdo->prepare("SELECT * FROM my_form WHERE text=:text");
$stmt->execute(['text' => $text]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!empty($result)) {
    $message = "You should check in on some of those fields below.";
    $_SESSION['danger'] = $message;

    header("Location: task_10.php");
    exit;
}

    $stmt = $pdo->prepare("INSERT INTO my_form (text) VALUE (:text)");
    $stmt->execute(['text' => $text]);

    $message = "You should check in on some of those fields below.";
    $_SESSION['success'] = $message;

    header("Location: task_10.php");
