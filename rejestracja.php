<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Dane do połączenia z bazą danych
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
    die("Błąd połączenia: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobierz dane z formularza
    $imie = $_POST['imie'] ?? '';
    $nazwisko = $_POST['nazwisko'] ?? '';
    $nazwa_uzytkownika = $_POST['nazwa_uzytkownika'] ?? '';
    $email = $_POST['email'] ?? '';
    $haslo = $_POST['haslo'] ?? '';
    $potwierdz_haslo = $_POST['potwierdz_haslo'] ?? '';

    // Walidacja danych
    $errors = [];

    if (empty($imie)) $errors[] = "Imię jest wymagane";
    if (empty($nazwisko)) $errors[] = "Nazwisko jest wymagane";
    if (empty($nazwa_uzytkownika)) $errors[] = "Nazwa użytkownika jest wymagana";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Podaj poprawny email";
    if (empty($haslo)) $errors[] = "Hasło jest wymagane";
    if ($haslo !== $potwierdz_haslo) $errors[] = "Hasła nie są identyczne";
    if (strlen($haslo) < 8) $errors[] = "Hasło musi mieć co najmniej 8 znaków";

   
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE email = ? OR nazwa_uzytkownika = ?");
        $stmt->execute([$email, $nazwa_uzytkownika]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            if ($existing_user['email'] === $email) $errors[] = "Email jest już zajęty";
            if ($existing_user['nazwa_uzytkownika'] === $nazwa_uzytkownika) $errors[] = "Nazwa użytkownika jest już zajęta";
        }
    }

   
    if (empty($errors)) {
        $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO uzytkownicy (imie, nazwisko, nazwa_uzytkownika, email, haslo, uprawnienia) 
                                  VALUES (?, ?, ?, ?, ?, 'uzytkownik')");
            $stmt->execute([$imie, $nazwisko, $nazwa_uzytkownika, $email, $haslo_hash]);
            
            
            $user_id = $pdo->lastInsertId();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $imie . ' ' . $nazwisko;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = 'uzytkownik';
            
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Błąd podczas rejestracji: " . $e->getMessage();
        }
    }

    
    if (!empty($errors)) {
        echo '<div class="error-container">';
        echo '<h2>Wystąpiły następujące błędy:</h2>';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul>';
        echo '<a href="rejestracja.html">Powrót do formularza rejestracji</a>';
        echo '</div>';
        exit;
    }
} else {
    header("Location: rejestracja.html");
    exit;
}
?>