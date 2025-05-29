<?php
$komunikat = ''; // zmienna na komunikat

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli('localhost', 'root', '', 'restauracja');
    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    $imie = $conn->real_escape_string($_POST['imie']);
    $nazwisko = $conn->real_escape_string($_POST['nazwisko']);
    $nazwa_uzytkownika = $conn->real_escape_string($_POST['nazwa_uzytkownika']);
    $email = $conn->real_escape_string($_POST['email']);
    $haslo = $conn->real_escape_string($_POST['password']); // Usunięto hashowanie
    $uprawnienia = 'uzytkownik';

    $checkQuery = "SELECT * FROM uzytkownicy WHERE nazwa_uzytkownika = '$nazwa_uzytkownika' OR email = '$email'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        $komunikat = "Użytkownik o podanej nazwie lub e-mailu już istnieje.";
    } else {
        $sql = "INSERT INTO uzytkownicy (imie, nazwisko, nazwa_uzytkownika, email, haslo, uprawnienia)
                VALUES ('$imie', '$nazwisko', '$nazwa_uzytkownika', '$email', '$haslo', '$uprawnienia')";

        if ($conn->query($sql) === TRUE) {
            $komunikat = "Rejestracja zakończona sukcesem!";
        } else {
            $komunikat = "Błąd podczas rejestracji: " . $conn->error;
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Rejestracja</title>
  <link rel="stylesheet" href="rejestracja.css" />
</head>
<body>
<?php if (!empty($komunikat)): ?>
  <script>alert("<?php echo htmlspecialchars($komunikat); ?>");</script>
<?php endif; ?>

<section class="form-section">
  <h2>Rejestracja</h2>
  <form action="rejestracja.php" method="post" onsubmit="return validatePasswords()">
    <input type="text" name="imie" placeholder="Imię" required>
    <input type="text" name="nazwisko" placeholder="Nazwisko" required>
    <input type="text" name="nazwa_uzytkownika" placeholder="Nazwa użytkownika" required>
    <input type="email" name="email" placeholder="Adres e-mail" required />
    <input type="password" name="password" id="password" placeholder="Hasło" required minlength="6" />
    <input type="password" name="confirm" id="confirm" placeholder="Potwierdź hasło" required minlength="6" />

    <label class="regulamin-label">
      <input type="checkbox" id="regulamin" />
      <span>Akceptuję <a href="regulamin.pdf" target="_blank">regulamin</a></span>
    </label>

    <button type="submit" id="submitBtn" class="submit-button" disabled>Zarejestruj się</button>
  </form>

  <a href="login.php" class="back-link">Masz już konto? Zaloguj się</a>
  <a href="index.php" class="back-link">Powrót do strony głównej</a>
</section>

<script>
  const checkbox = document.getElementById('regulamin');
  const submitBtn = document.getElementById('submitBtn');

  checkbox.addEventListener('change', () => {
    submitBtn.disabled = !checkbox.checked;
  });

  const emailInput = document.querySelector('input[name="email"]');

  emailInput.addEventListener('input', () => {
    const emailValue = emailInput.value;
    const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue);

    if (!isValid) {
      emailInput.setCustomValidity("Wprowadź poprawny adres e-mail");
    } else {
      emailInput.setCustomValidity("");
    }
  });

  function validatePasswords() {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirm').value;
    const hasUppercase = /[A-Z]/.test(password);
    const hasDigit = /\d/.test(password);

    if (!hasUppercase || !hasDigit) {
      alert('Hasło musi zawierać co najmniej jedną wielką literę i jedną cyfrę.');
      return false;
    }

    if (password !== confirm) {
      alert('Hasła nie są takie same.');
      return false;
    }

    return true;
  }
</script>
</body>
</html>