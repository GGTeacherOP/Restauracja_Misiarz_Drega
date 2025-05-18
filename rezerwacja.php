<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'restauracja';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

// Obsługa formularza
$komunikat = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $telefon = $_POST['telefon'];
    $data = $_POST['data'];
    $godzina = $_POST['godzina'];
    $ilosc_osob = $_POST['ilosc_osob'];

    // Sprawdź zajęte stoliki w tej dacie i godzinie
    $sql = "SELECT stolik_nr FROM rezerwacje WHERE data = '$data' AND godzina = '$godzina'";
    $result = $conn->query($sql);

    $zajete = [];
    while ($row = $result->fetch_assoc()) {
        $zajete[] = $row['stolik_nr'];
    }

    // Znajdź pierwszy wolny stolik
    $wolny_stolik = null;
    for ($i = 1; $i <= 13; $i++) {
        if (!in_array($i, $zajete)) {
            $wolny_stolik = $i;
            break;
        }
    }

    if ($wolny_stolik !== null) {
        $stmt = $conn->prepare("INSERT INTO rezerwacje (imie, nazwisko, telefon, data, godzina, ilosc_osob, stolik_nr) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $imie, $nazwisko, $telefon, $data, $godzina, $ilosc_osob, $wolny_stolik);
        $stmt->execute();
        $komunikat = "Rezerwacja zapisana! Przydzielono stolik nr $wolny_stolik.";
    } else {
        $komunikat = "Brak dostępnych stolików o wybranej godzinie.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rezerwacje</title>
    <link rel="stylesheet" href="rezerwacja.css" />
</head>
<body>

<div class="container">
    <div class="info">
        <h2>Grupy</h2>
        <p>Dla grup liczących 10 lub więcej osób, prosimy o kontakt telefoniczny celem rezerwacji stolika.</p>
        <h2>Szczegóły rezerwacji</h2>
        <p>Dla grup liczących 10 lub więcej osób, prosimy o kontakt telefoniczny.</p>
        <h2>Spóźnienia</h2>
        <p>Przestrzeganie godziny rezerwacji jest bardzo ważne. W przypadku spóźnienia powyżej 15 minut, niestety będziemy zmuszeni przekazać zarezerwowany stolik innym gościom.</p>
    </div>

</div>

    <div class="formularz">
        <h2>Formularz rezerwacji</h2>
        <form method="POST" id="rezerwacjaForm">
            <label>Imię: <input type="text" name="imie" required></label><br><br>
            <label>Nazwisko: <input type="text" name="nazwisko" required></label><br><br>
            <label>Telefon: <input type="tel" name="telefon" required></label>
            <label>Data: <input type="date" name="data" id="data" required></label><br><br>
            <label>Ilość osób: <input type="number" name="ilosc_osob" min="1" max="9" required></label><br><br>
            <input type="submit" value="Rezerwuj">
        </form>
        <div class="komunikat"><?= $komunikat ?></div><br><br><br><br>
    <a href="index.html" class="back-btn">← Powrót do strony głównej</a>

    </div>
</div>
</body>
</html>
