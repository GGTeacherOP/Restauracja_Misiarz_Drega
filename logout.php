<?php
session_start();
require_once 'db_config.php';


if (isset($_SESSION['user_id'])) {
    try {
        $stmt = $pdo->prepare("UPDATE uzytkownicy SET remember_token = NULL, token_expiry = NULL WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
    } catch (PDOException $e) {
        error_log("Błąd podczas czyszczenia tokena: " . $e->getMessage());
    }
}


$_SESSION = [];
session_destroy();


if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/');
}


header('Location: index.php');
exit;
?>