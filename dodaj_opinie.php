<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tresc = $_POST['tresc'] ?? '';
    $ocena = $_POST['ocena'] ?? 0;
    $user_id = $_SESSION['user_id'];

    if (empty($tresc) || empty($ocena)) {
        die("Proszę wypełnić wszystkie pola");
    }

    $stmt = $pdo->prepare("INSERT INTO opinie (user_id, tresc, ocena) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $tresc, $ocena]);

    header("Location: index.html#opinie");
    exit;
}
?>