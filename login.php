<!DOCTYPE html>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Logowanie</title>
  <link rel="stylesheet" href="login.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="login-container">
    <h2>Zaloguj się</h2>
    form action="login.php" method="post">
  <input type="email" name="email" placeholder="Adres email" required />
  <input type="password" name="password" placeholder="Hasło" required />
  
  <label class="remember-me">
    <input type="checkbox" name="remember" id="remember">
    <span>Zapamiętaj mnie</span>
  </label>
  
  <div class="buttons">
    <button type="submit" class="login-btn">Zaloguj</button>
    <a href="rejestracja.php" class="register-btn">Zarejestruj się</a>
  </div>
</form>
    <a href="index.php" class="back-btn">← Powrót do strony głównej</a>
    <?php if (isset($error)): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
  </div>
</body>
</html>