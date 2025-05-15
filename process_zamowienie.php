<?php
$host = 'localhost';
$db   = 'restauracja';
$user = 'root'; 
$pass = '';     
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}


$ceny_dan = [
    'Pizza Primavera' => 44.00,
    'Burger Ostry Maciuś' => 56.00,
    'Żeberka BBQ' => 58.00,
    'Makaron Pappardelle z Kurczakiem' => 42.00,
    'Pizza Parma' => 45.00,
    'Burger Kraftowy' => 70.00,
    'Cheeseburger' => 40.00,
    'Żeberka w Cebuli' => 58.00,
    'Burger BBQ' => 47.00,
    'Spaghetti alla Carbonara' => 41.00,
    'Penne alla Vodka' => 38.00,
    'Pizza Diavola' => 45.00,
    'Pizza Salsiccia' => 45.00,
    'Woda mineralna' => 8.00,
    'Cola / Fanta / Sprite' => 10.00,
    'Piwo kraftowe' => 16.00
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $errors = [];
    
    if (empty($_POST['imie'])) {
        $errors[] = 'Proszę podać imię i nazwisko';
    }
    
    if (empty($_POST['telefon'])) {
        $errors[] = 'Proszę podać numer telefonu';
    }
    
    if (empty($_POST['adres'])) {
        $errors[] = 'Proszę podać adres odbioru';
    }
    
    if (empty($_POST['dania'])) {
        $errors[] = 'Proszę wybrać przynajmniej jedno danie';
    }
    
    
    if (!empty($errors)) {
        echo '<div class="error-container">';
        echo '<h2>Wystąpiły następujące błędy:</h2>';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul>';
        echo '<a href="zamowienie.html">Powrót do formularza</a>';
        echo '</div>';
        exit;
    }
    
   
    $wybrane_dania = $_POST['dania'];
    $cena_calkowita = 0;
    $nazwy_dan = [];
    
    foreach ($wybrane_dania as $danie) {
        if (isset($ceny_dan[$danie])) {
            $cena_calkowita += $ceny_dan[$danie];
            $nazwy_dan[] = $danie;
        }
    }
    
    $dania_text = implode(', ', $nazwy_dan);
    
    
    try {
        $stmt = $pdo->prepare("INSERT INTO zamowienia (imie_nazwisko, telefon, adres, dania, cena) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['imie'],
            $_POST['telefon'],
            $_POST['adres'],
            $dania_text,
            $cena_calkowita
        ]);
        
        echo '<!DOCTYPE html>
        <html lang="pl">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Potwierdzenie zamówienia</title>
            <link rel="stylesheet" href="zamowienie.css">
            <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
        </head>
        <body>
            <div class="order-container">
                <h1>Dziękujemy za zamówienie!</h1>
                <div class="order-summary">
                    <h2>Podsumowanie zamówienia:</h2>
                    <p><strong>Imię i nazwisko:</strong> ' . htmlspecialchars($_POST['imie']) . '</p>
                    <p><strong>Telefon:</strong> ' . htmlspecialchars($_POST['telefon']) . '</p>
                    <p><strong>Adres:</strong> ' . htmlspecialchars($_POST['adres']) . '</p>
                    <p><strong>Zamówione dania:</strong> ' . htmlspecialchars($dania_text) . '</p>
                    <p><strong>Do zapłaty:</strong> ' . number_format($cena_calkowita, 2) . ' zł</p>
                    <p>Numer Twojego zamówienia: #' . $pdo->lastInsertId() . '</p>
                </div>
                <a href="index.html" class="back-link">← Powrót do strony głównej</a>
            </div>
        </body>
        </html>';
        
    } catch (PDOException $e) {
        echo '<div class="error-container">';
        echo '<h2>Wystąpił błąd podczas przetwarzania zamówienia</h2>';
        echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<a href="zamowienie.html">Powrót do formularza</a>';
        echo '</div>';
    }
} else {
    header('Location: zamowienie.html');
    exit;
}
?>