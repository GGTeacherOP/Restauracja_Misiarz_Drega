<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html?redirect=zamowienie.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zamów Online</title>
  <link rel="stylesheet" href="zamowienie.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="order-container">
    <h1>Zamów Online - Na Wynos</h1>
    <form action="process_zamowienie.php" method="post">
      <fieldset>
        <legend>Wybierz dania:</legend>

        <label><input type="checkbox" name="dania[]" value="Pizza Primavera"> Pizza Primavera – 44,00zł</label>
        <label><input type="checkbox" name="dania[]" value="Burger Ostry Maciuś"> Burger Ostry Maciuś – 56,00zł</label>
        <label><input type="checkbox" name="dania[]" value="Żeberka BBQ"> Żeberka BBQ – 58,00zł</label>
        <label><input type="checkbox" name="dania[]" value="Makaron Pappardelle z Kurczakiem"> Makaron Pappardelle – 42,00zł</label>
        <label><input type="checkbox" name="dania[]" value="Pizza Parma"> Pizza Parma – 45,00zł</label>
        <label><input type="checkbox" name="dania[]" value="Burger Kraftowy"> Burger Kraftowy – 70,00zł</label>
        <label><input type="checkbox" name="dania[]" value="Cheeseburger"> Cheeseburger – 40,00zł</label>
        <label><input type="checkbox" name="dania[]" value="Żeberka w Cebuli"> Żeberka w Cebuli – 58,00zł</label>
        <label><input type="checkbox" name="dania[]" value="Burger BBQ"> Burger BBQ – 47,00 zł</label>
        <label><input type="checkbox" name="dania[]" value="Spaghetti alla Carbonara"> Spaghetti alla Carbonara – 41,00 zł</label>
        <label><input type="checkbox" name="dania[]" value="Penne alla Vodka"> Penne alla Vodka – 38,00 zł</label>
        <label><input type="checkbox" name="dania[]" value="Pizza Diavola "> Pizza Diavola – 45,00 zł</label>
        <label><input type="checkbox" name="dania[]" value="Pizza Salsiccia"> Pizza Salsiccia – 45,00 zł</label>
        <label><input type="checkbox" name="dania[]" value="Woda mineralna"> Woda mineralna – 8,00zł</label>
        <label><input type="checkbox" name="dania[]" value="Cola / Fanta / Sprite"> Cola / Fanta / Sprite – 10,00zł</label>
        <label><input type="checkbox" name="dania[]" value="Piwo kraftowe"> Piwo kraftowe – 16,00zł</label>
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
</body>
</html>
