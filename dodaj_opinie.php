<?php
session_start();
require_once 'db_config.php';

$komunikat = ''; // Zapobiega ostrzeżeniom, inicjalizacja

// Autologowanie przez ciasteczko remember_token
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE remember_token = ? AND token_expiry > NOW()");
        $stmt->execute([$_COOKIE['remember_token']]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_username'] = $user['nazwa_uzytkownika'];
            $_SESSION['user_name'] = $user['imie'] . ' ' . $user['nazwisko'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['uprawnienia'];

            $newToken = bin2hex(random_bytes(32));
            $newExpiry = time() + 60 * 60 * 24 * 30;

            $stmt = $pdo->prepare("UPDATE uzytkownicy SET remember_token = ?, token_expiry = ? WHERE id = ?");
            $stmt->execute([$newToken, date('Y-m-d H:i:s', $newExpiry), $user['id']]);

            setcookie('remember_token', $newToken, $newExpiry, '/', '', true, true);
        } else {
            setcookie('remember_token', '', time() - 3600, '/');
        }
    } catch (PDOException $e) {
        error_log("Auto-login error: " . $e->getMessage());
    }
}

// Obsługa formularza
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['user_id'])) {
    $tresc = trim($_POST['tresc']);

    if (!empty($tresc)) {
        try {
            // Pobranie nazwy użytkownika z bazy na podstawie ID
            $stmt = $pdo->prepare("SELECT nazwa_uzytkownika FROM uzytkownicy WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch();

            if ($user) {
                $nazwaUzytkownika = $user['nazwa_uzytkownika'];

                $stmt = $pdo->prepare("INSERT INTO opinie (uzytkownik_id, nazwa_uzytkownika, tresc, data_dodania) VALUES (?, ?, ?, NOW())");
                $stmt->execute([$_SESSION['user_id'], $nazwaUzytkownika, $tresc]);
                $komunikat = "<p style='color:green;'>✅ Dziękujemy za opinię!</p>";
            } else {
                $komunikat = "<p style='color:red;'>Nie znaleziono użytkownika.</p>";
            }
        } catch (PDOException $e) {
            $komunikat = "<p style='color:red;'>Błąd podczas zapisu opinii: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        $komunikat = "<p style='color:red;'>⚠️ Treść opinii nie może być pusta.</p>";
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

    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="dodaj_opinie.php" method="POST" class="formularz-opinia">
            <label for="tresc">Twoja opinia:</label><br>
            <textarea id="tresc" name="tresc" rows="4" required></textarea><br><br>
            <button type="submit">Wyślij opinię</button>
        </form>
    <?php else: ?>
        <p>Aby dodać opinię, <a href="login.php?redirect=dodaj_opinie.php">zaloguj się</a>.</p>
    <?php endif; ?>

    <p><a href="index.php" class="back-btn">← Powrót do strony głównej</a></p>
</body>
</html>
