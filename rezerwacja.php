<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany - załóżmy, że $_SESSION['user_id'] jest ustawione po logowaniu
if (!isset($_SESSION['user_id'])) {
    // Jeśli nie zalogowany, przekieruj na stronę logowania
    header('Location: login.php');
    exit();
}

// dalsza część strony z formularzem rezerwacji...
?>


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
    for ($i = 1; $i <= 14; $i++) {
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
        <p>Dla grup liczących 10 lub więcej osób, prosimy o kontakt telefoniczny pod numer 123 456 789</p>
        <h2>Spóźnienia</h2>
        <p>Przestrzeganie godziny rezerwacji jest bardzo ważne. W przypadku spóźnienia powyżej 15 minut, niestety będziemy zmuszeni przekazać zarezerwowany stolik innym gościom.</p>

        <h2>Rzut z góry restauracji</h2>
        <p>Kliknij na obrazek, aby go powiększyć i zobaczyć, gdzie znajduje się Twój stolik.</p>

        <img src="stoliki.png" alt="Rzut restauracji z góry" class="plan" id="thumbnail">

        <div id="lightbox" class="lightbox">
            <span class="close" id="closeBtn">&times;</span>
            <img class="lightbox-content" id="lightbox-img" alt="Powiększony rzut">
        </div>
    </div>

    <div class="formularz">
        <h2>Formularz rezerwacji</h2>
        <form method="POST" id="rezerwacjaForm">
            <label>Imię: <input type="text" name="imie" placeholder="Imię" required></label><br><br>
            <label>Nazwisko: <input type="text" name="nazwisko"  placeholder="Nazwisko" required></label><br><br>
            <label>Telefon: <input type="tel" name="telefon" id="telefon" pattern="^\+48-\d{3}-\d{3}-\d{3}$" placeholder="+48-000-000-000" required></label>
            <label>Data: <input type="date" name="data" id="data" required></label><br><br>
            <div id="godziny"></div><br>
            <input type="hidden" name="godzina" id="wybranaGodzina" required>
            <label>Ilość osób: <input type="number" name="ilosc_osob" placeholder="1-4 osób" min="1" max="4" required></label><br><br>
            <input type="submit" value="Rezerwuj">
        </form>
        <div class="komunikat"><?= $komunikat ?></div><br><br><br><br>
    <a href="index.php" class="back-btn">← Powrót do strony głównej</a>

    </div>
</div>

<script>

    const dzisiaj = new Date().toISOString().split('T')[0];
    document.getElementById("data").setAttribute('min', dzisiaj);

document.getElementById('data').addEventListener('change', function () {
    const data = this.value;
    fetch('godziny.php?data=' + data)
        .then(res => res.json())
        .then(godziny => {
            const kontener = document.getElementById('godziny');
            kontener.innerHTML = '<h3>Dostępne godziny:</h3>';
            godziny.forEach(item => {
                const blok = document.createElement('div');
                blok.className = 'godzina';
                if (item.status === 'zajeta') {
                    blok.classList.add('niedostepna');
                    blok.textContent = item.godzina;
                } else {
                    blok.textContent = item.godzina;
                    blok.style.cursor = 'pointer';
                    blok.onclick = function () {
                        document.querySelectorAll('.godzina').forEach(el => el.classList.remove('wybrana'));
                        blok.classList.add('wybrana');
                        document.getElementById('wybranaGodzina').value = item.godzina;
                    };
                }
                kontener.appendChild(blok);
            });
        });
});

// Obsługa telefonu - tak jak wcześniej

const telefonInput = document.getElementById('telefon');

telefonInput.addEventListener('focus', function () {
    if (!this.value.startsWith('+48-')) {
        this.value = '+48-';
        this.setSelectionRange(this.value.length, this.value.length);
    }
});

telefonInput.addEventListener('input', function () {
    let cursorPos = this.selectionStart;
    let originalLength = this.value.length;

    let digits = this.value.replace(/\D/g, '');

    if (digits.startsWith('48')) {
        digits = digits.substring(2);
    }

    digits = digits.substring(0, 9);

    let formatted = '+48-';

    if (digits.length > 6) {
        formatted += digits.substring(0, 3) + '-' + digits.substring(3, 6) + '-' + digits.substring(6);
    } else if (digits.length > 3) {
        formatted += digits.substring(0, 3) + '-' + digits.substring(3);
    } else {
        formatted += digits;
    }

    this.value = formatted;

    let newLength = this.value.length;
    cursorPos = cursorPos + (newLength - originalLength);
    this.setSelectionRange(cursorPos, cursorPos);
});

// Dodatkowo możesz zablokować wysłanie formularza, jeśli nie wybrano godziny

document.getElementById('rezerwacjaForm').addEventListener('submit', function(e) {
    const godzinaVal = document.getElementById('wybranaGodzina').value;
    if (!godzinaVal) {
        alert('Proszę wybrać godzinę rezerwacji.');
        e.preventDefault();
    }
});

  const thumbnail = document.getElementById("thumbnail");
  const lightbox = document.getElementById("lightbox");
  const lightboxImg = document.getElementById("lightbox-img");
  const closeBtn = document.getElementById("closeBtn");

  thumbnail.addEventListener("click", () => {
    lightbox.style.display = "block";
    lightboxImg.src = thumbnail.src;
  });

  closeBtn.addEventListener("click", () => {
    lightbox.style.display = "none";
  });

  window.addEventListener("click", (event) => {
    if (event.target === lightbox) {
      lightbox.style.display = "none";
    }
  });

</script>

</body>
</html>
