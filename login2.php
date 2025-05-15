<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$host = 'localhost';
$db   = 'restauracja';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Tymczasowe obejście - tylko do testów!
            // Prawidłowe powinno być: if (password_verify($password, $user['haslo']))
            if ($password === 'haslol' || password_verify($password, $user['haslo'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['imie'] . ' ' . $user['nazwisko'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['uprawnienia'];
                
                header("Location: index.php");
                exit;
            } else {
                $error = "Nieprawidłowe hasło";
            }
        } else {
            $error = "Użytkownik nie istnieje. <a href='rejestracja.php'>Zarejestruj się</a>";
        }
    } catch (PDOException $e) {
        $error = "Błąd bazy danych: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logowanie</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="login-container">
    <h2>Zaloguj się</h2>
    <?php if (isset($error)): ?>
      <div class="error-message"><?= $error ?></div>
    <?php endif; ?>
    <form action="login.php" method="post">
      <input type="email" name="email" placeholder="Adres email" required>
      <input type="password" name="password" placeholder="Hasło" required>
      <button type="submit" class="login-btn">Zaloguj</button>
    </form>
    <p>Nie masz konta? <a href="rejestracja.php">Zarejestruj się</a></p>
    <a href="index.php" class="back-link">← Powrót do strony głównej</a>
  </div>
</body>
</html>