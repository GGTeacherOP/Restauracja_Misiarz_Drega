<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?redirect=zamowienie.php');
    exit;
}

// Ceny dań - zgodne z menu.php (z rozdzieleniem napojów)
$ceny_dan = [
    // Dania główne
    'Burger Kraftowy' => 70.00,
    'Burger BBQ' => 47.00,
    'Burger Ostry Maciuś' => 56.00,
    'Cheeseburger' => 40.00,
    'Żeberka BBQ' => 58.00,
    'Tradycyjne Żeberka w Cebul' => 58.00,
    'Spaghetti alla Carbonara' => 41.00,
    'Penne alla Vodka' => 38.00,
    'Makaron Pappardelle z Kurczakiem' => 42.00,
    'Pizza Diavola' => 45.00,
    'Pizza Primavera' => 44.00,
    'Pizza Salsiccia' => 45.00,
    'Pizza Parma' => 45.00,
    
    // Napoje
    'Piwo Kraftowe' => 16.00,
    'Woda Mineralna' => 8.00,
    'Cola' => 10.00,
    'Fanta' => 10.00,
    'Sprite' => 10.00
];

// Obsługa formularza
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    // Walidacja pól
    if (empty($_POST['imie'])) $errors[] = 'Proszę podać imię i nazwisko';
    if (empty($_POST['telefon'])) $errors[] = 'Proszę podać numer telefonu';
    if (empty($_POST['adres'])) $errors[] = 'Proszę podać adres odbioru';
    if (empty($_POST['dania'])) $errors[] = 'Proszę wybrać przynajmniej jedno danie';
    
    if (!empty($errors)) {
        // Wyświetl błędy i wróć do formularza
        echo '<div class="error-container">';
        echo '<h2>Wystąpiły następujące błędy:</h2>';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul>';
        echo '<a href="zamowienie.php">Powrót do formularza</a>';
        echo '</div>';
        exit;
    }
    
    // Przetwarzanie zamówienia z uwzględnieniem ilości
    $dania = [];
    $cena_total = 0;
    
    foreach ($_POST['dania'] as $index => $nazwa_dania) {
        $ilosc = (int)$_POST['ilosci'][$index];
        if ($ilosc > 0 && isset($ceny_dan[$nazwa_dania])) {
            $cena = $ceny_dan[$nazwa_dania];
            $dania[] = "$nazwa_dania (x$ilosc)";
            $cena_total += $cena * $ilosc;
        }
    }
    
    $dania_text = implode(", ", $dania);
    
    // Zapisz do bazy
    try {
        $stmt = $pdo->prepare("INSERT INTO zamowienia (imie_nazwisko, telefon, adres, dania, cena, data_zamowienia, status, user_id) 
                              VALUES (?, ?, ?, ?, ?, NOW(), 'nowe', ?)");
        $stmt->execute([
            $_POST['imie'],
            $_POST['telefon'],
            $_POST['adres'],
            $dania_text,
            $cena_total,
            $_SESSION['user_id']
        ]);
        
        // Wyświetl potwierdzenie
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
                    <p><strong>Do zapłaty:</strong> ' . number_format($cena_total, 2) . ' zł</p>
                    <p>Numer Twojego zamówienia: #' . $pdo->lastInsertId() . '</p>
                </div>
                <a href="index.php" class="back-link">← Powrót do strony głównej</a>
            </div>
        </body>
        </html>';
        exit;
        
    } catch (PDOException $e) {
        $error = "Błąd podczas zapisywania zamówienia: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zamów Online</title>
  <link rel="stylesheet" href="zamowienie.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <script>
    function updateTotal() {
      let total = 0;
      const checkboxes = document.querySelectorAll('input[name="dania[]"]:checked');
      
      checkboxes.forEach(checkbox => {
        const quantity = parseInt(document.getElementById(`quantity_${checkbox.value}`).value);
        const price = parseFloat(checkbox.dataset.price);
        total += price * quantity;
      });
      
      document.getElementById('total-price').textContent = total.toFixed(2);
    }
    
    function toggleQuantity(daniaCheckbox) {
      const quantityInput = document.getElementById(`quantity_${daniaCheckbox.value}`);
      quantityInput.disabled = !daniaCheckbox.checked;
      if (!daniaCheckbox.checked) quantityInput.value = 1;
      updateTotal();
    }
  </script>
</head>
<body>
  <div class="order-container">
    <h1>Zamów Online - Na Wynos</h1>
    
    <?php if (isset($_GET['success'])): ?>
      <div class="success-message">Zamówienie zostało złożone! Dziękujemy.</div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form action="zamowienie.php" method="post">
      <fieldset>
        <legend>Wybierz dania:</legend>
        
        <h3>Dania główne</h3>
        <table>
          <tr>
            <th>Danie</th>
            <th>Cena</th>
            <th>Ilość</th>
          </tr>
          
          <?php 
          // Dania główne
          $dania_glowne = [
              'Burger Kraftowy', 'Burger BBQ', 'Burger Ostry Maciuś', 'Cheeseburger',
              'Żeberka BBQ', 'Tradycyjne Żeberka w Cebul', 'Spaghetti alla Carbonara',
              'Penne alla Vodka', 'Makaron Pappardelle z Kurczakiem', 'Pizza Diavola',
              'Pizza Primavera', 'Pizza Salsiccia', 'Pizza Parma'
          ];
          
          foreach ($dania_glowne as $nazwa): ?>
          <tr>
            <td>
              <label>
                <input type="checkbox" name="dania[]" value="<?= htmlspecialchars($nazwa) ?>" 
                      data-price="<?= $ceny_dan[$nazwa] ?>" onchange="toggleQuantity(this)">
                <?= htmlspecialchars($nazwa) ?>
              </label>
            </td>
            <td><?= number_format($ceny_dan[$nazwa], 2) ?> zł</td>
            <td>
              <input type="number" id="quantity_<?= htmlspecialchars($nazwa) ?>" 
                    name="ilosci[]" value="1" min="1" max="10" disabled 
                    onchange="updateTotal()">
            </td>
          </tr>
          <?php endforeach; ?>
        </table>
        
        <h3>Napoje</h3>
<table>
  <tr>
    <th>Napoje</th>
    <th>Cena</th>
    <th>Ilość</th>
  </tr>
  
  <?php 
  $napoje = [
      'Piwo Kraftowe', 'Woda Mineralna', 'Cola', 'Fanta', 'Sprite'
  ];
  
  foreach ($napoje as $nazwa): ?>
  <tr>
    <td>
      <label>
        <input type="checkbox" name="dania[]" value="<?= htmlspecialchars($nazwa) ?>" 
              data-price="<?= $ceny_dan[$nazwa] ?>" onchange="toggleQuantity(this)">
        <?= htmlspecialchars($nazwa) ?>
      </label>
    </td>
    <td><?= number_format($ceny_dan[$nazwa], 2) ?> zł</td>
    <td>
      <input type="number" id="quantity_<?= htmlspecialchars($nazwa) ?>" 
            name="ilosci[]" value="1" min="1" max="10" disabled 
            onchange="updateTotal()">
    </td>
  </tr>
  <?php endforeach; ?>
</table>
        
        <div class="total-price">
          <strong>Suma: <span id="total-price">0.00</span> zł</strong>
        </div>
      </fieldset>

      <fieldset>
        <legend>Dane kontaktowe:</legend>
        <input type="text" name="imie" placeholder="Twoje imię i nazwisko" required>
        <input type="tel" name="telefon" placeholder="Numer telefonu" required>
        <input type="text" name="adres" placeholder="Adres odbioru (ulica, nr domu)" required>
      </fieldset>

      <button type="submit">Złóż Zamówienie</button>
    </form>

    <a href="index.php" class="back-link">← Powrót do strony głównej</a>
  </div>
  
  <script>
    // Inicjalizacja wyliczenia ceny
    updateTotal();
  </script>
</body>
</html>