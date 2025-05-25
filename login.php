<?php
session_start();
require_once 'db_config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    try {
        $stmt = $pdo->prepare("SELECT id, imie, nazwisko, haslo, uprawnienia FROM uzytkownicy WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && $password === $user['haslo']) { // Porównanie w czystym tekście
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['imie'] . ' ' . $user['nazwisko'];
            $_SESSION['user_role'] = $user['uprawnienia'];
            
            if (isset($_POST['remember'])) {
                setcookie('remember_user', $user['id'], time() + (30 * 24 * 60 * 60), "/");
            }
            
            header('Location: index.php');
            exit;
        } else {
            $error = 'Nieprawidłowy email lub hasło';
        }
    } catch (PDOException $e) {
        $error = 'Błąd systemu. Spróbuj ponownie.';
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Logowanie</title>
  <link rel="stylesheet" href="login.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="login-container">
    <h2>Zaloguj się</h2>
    <?php if (!empty($error)): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="login.php" method="post">
      <input type="email" name="email" placeholder="Adres email" required />
      <input type="password" name="password" placeholder="Hasło" required />
      
      <label class="remember-me">
        <input type="checkbox" name="remember" id="remember">
        <span>Zapamiętaj mnie</span>
      </label>
      
      <div class="buttons">
        <button type="submit" class="login-btn">Zaloguj</button>
        <a href="rejestracja.php" class="register-btn">Zarejestruj się</a>
      </div>
    </form>

    <a href="index.php" class="back-btn">← Powrót do strony głównej</a>
  </div>
</body>
</html>