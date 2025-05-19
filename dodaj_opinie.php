<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php?redirect=dodaj_opinie.php');
  exit;
}

require_once 'db_config.php'; // Plik z konfiguracją PDO

$komunikat = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = htmlspecialchars(trim($_POST['imie'] ?? ''));
    $tresc = htmlspecialchars(trim($_POST['tresc'] ?? ''));
    $user_id = $_SESSION['user_id'];

    if (!empty($imie) && !empty($tresc)) {
        $stmt = $pdo->prepare("INSERT INTO opinie (uzytkownik_id, imie, tresc, data_dodania) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$uzytkownik_id, $imie, $tresc]);
        header("Location: index.php#opinie");
        exit;
    } else {
        $komunikat = "<p style='color:red;'>Wypełnij wszystkie pola.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Dodaj opinię</title>
  <link rel="stylesheet" href="opinie.css">
</head>
<body>
  <h1>Dodaj swoją opinię</h1>

  <?= $komunikat ?>

  <form action="dodaj_opinie.php" method="POST" class="formularz-opinia">
    <label for="imie">Twoje imię:</label><br>
    <input type="text" id="imie" name="imie" required><br><br>

    <label for="tresc">Twoja opinia:</label><br>
    <textarea id="tresc" name="tresc" rows="4" required></textarea><br><br>

    <button type="submit">Wyślij opinię</button>
  </form>

  <p><a href="index.php" class="back-btn">← Powrót do strony głównej</a></p>
</body>
</html>
