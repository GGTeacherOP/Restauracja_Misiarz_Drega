<?php
session_start();
require_once 'db_config.php';


if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    try {
        $stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['haslo'])) {
           
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['imie'] . ' ' . $user['nazwisko'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['uprawnienia'];

            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $expiry = time() + 60 * 60 * 24 * 30; 

                
                $stmt = $pdo->prepare("UPDATE uzytkownicy SET remember_token = ?, token_expiry = ? WHERE id = ?");
                $stmt->execute([$token, date('Y-m-d H:i:s', $expiry), $user['id']]);

                
                setcookie('remember_token', $token, $expiry, '/');
            }

            header('Location: index.php');
            exit;
        } else {
            $error = 'Nieprawidłowy email lub hasło';
        }
    } catch (PDOException $e) {
        $error = 'Błąd podczas logowania: ' . $e->getMessage();
    }
}
?>