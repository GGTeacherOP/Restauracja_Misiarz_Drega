<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'restauracja';
$conn = new mysqli($host, $user, $pass, $db);

$data = $_GET['data'];
$godziny = [];

for ($h = 12; $h <= 21; $h++) {
    $godzina = sprintf("%02d:00", $h);
    $sql = "SELECT COUNT(*) as ilosc FROM rezerwacje WHERE data = '$data' AND godzina = '$godzina'";
    $res = $conn->query($sql)->fetch_assoc();
    $zajete = $res['ilosc'] >= 13; // Zakładamy max 13 stolików
    $godziny[] = [
        'godzina' => $godzina,
        'status' => $zajete ? 'zajeta' : 'wolna'
    ];
}

header('Content-Type: application/json');
echo json_encode($godziny);
?>
