<?php
session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sprawdzenie czy użytkownik jest zalogowany
    if (!isset($_SESSION['user_id'])) {
        // Przekierowanie do logowania, z powrotem do kontakt.php po zalogowaniu
        header("Location: login.php?redirect=kontakt.php");
        exit;
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $user_id = $_SESSION['user_id'];

    if ($name !== '' && $email !== '' && $message !== '') {
        try {
            $stmt = $pdo->prepare("INSERT INTO pytania (uzytkownik_id, imie, email, tresc, data_dodania) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$user_id, $name, $email, $message]);

            header("Location: index.php?success=1#kontakt");
            exit;
        } catch (PDOException $e) {
            // Możesz dodać logowanie błędu lub wyświetlić komunikat
            header("Location: index.php?success=0#kontakt");
            exit;
        }
    } else {
        header("Location: index.php?success=0#kontakt");
        exit;
    }
} else {
    // Jeśli ktoś otworzy kontakt.php bez POST, można przekierować lub pokazać formularz
    header("Location: index.php#kontakt");
    exit;
}
