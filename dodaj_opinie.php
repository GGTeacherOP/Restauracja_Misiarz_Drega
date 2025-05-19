<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Dodaj opinię</title>
  <link rel="stylesheet" href="opinie.css"> <!-- Jeśli masz styl CSS -->
</head>
<body>
  <h1>Dodaj swoją opinię</h1>

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

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "restauracja");

    if ($conn->connect_error) {
      echo "<p>Błąd połączenia z bazą danych.</p>";
    } else {
      $imie = htmlspecialchars(trim($_POST["imie"]));
      $tresc = htmlspecialchars(trim($_POST["tresc"]));

      if (!empty($imie) && !empty($tresc)) {
        // Dodaj opinię do bazy danych z aktualną datą
        $stmt = $conn->prepare("INSERT INTO opinie (imie, tresc, data_dodania) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $imie, $tresc);
        $stmt->execute();
        echo "<p style='color:green;'>Dziękujemy za opinię!</p>";
      } else {
        echo "<p style='color:red;'>Wypełnij wszystkie pola.</p>";
      }

      $conn->close();
    }
  }
  ?>

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
