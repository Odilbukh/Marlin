<?php


$text = $_POST['text'];

$pdo =  new PDO('mysql:host=localhost;dbname=marlin', 'root', 'root');

$stmt = $pdo->prepare("INSERT INTO my_form(text) VALUE (:text)");
$stmt->execute(['text' => $text]);

header("Location: task_9.php");