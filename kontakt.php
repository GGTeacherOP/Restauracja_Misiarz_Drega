<?php
// kontakt.php
session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    $user_id = $_SESSION['user_id'] ?? null;

    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO pytania (uzytkownik_id, imie, email, tresc, data_dodania) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$user_id, $name, $email, $message]);

        header("Location: index.php?success=1#kontakt");
        exit;
    } else {
        header("Location: index.php?success=0#kontakt");
        exit;
    }
}
