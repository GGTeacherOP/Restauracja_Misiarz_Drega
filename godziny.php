<?php
// Dane do połączenia z bazą danych
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'restauracja';

// Nawiązanie połączenia z bazą danych przy użyciu mysqli
$conn = new mysqli($host, $user, $pass, $db);

// Pobranie daty z parametru GET (np. ?data=2025-05-19)
$data = $_GET['data'];

// Inicjalizacja pustej tablicy na godziny i ich status
$godziny = [];

// Pętla po godzinach od 12:00 do 21:00
for ($h = 12; $h <= 21; $h++) {
    // Formatowanie godziny jako string, np. "12:00", "13:00"
    $godzina = sprintf("%02d:00", $h);

    // Zapytanie SQL sprawdzające, ile jest rezerwacji na daną datę i godzinę
    $sql = "SELECT COUNT(*) as ilosc FROM rezerwacje WHERE data = '$data' AND godzina = '$godzina'";
    
    // Wykonanie zapytania i pobranie liczby rezerwacji
    $res = $conn->query($sql)->fetch_assoc();

    // Sprawdzenie, czy wszystkie 14 stolików są zajęte
    $zajete = $res['ilosc'] >= 14;

    // Dodanie informacji o godzinie i jej statusie do tablicy
    $godziny[] = [
        'godzina' => $godzina,
        'status' => $zajete ? 'zajeta' : 'wolna' // ternary operator
    ];
}

// Ustawienie nagłówka odpowiedzi na JSON
header('Content-Type: application/json');

// Zwrócenie danych w formacie JSON (do wykorzystania np. w JS)
echo json_encode($godziny);
?>
