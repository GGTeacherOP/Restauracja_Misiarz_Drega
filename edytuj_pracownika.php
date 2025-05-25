<?php
session_start();
require_once 'db_config.php';


if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'wlasciciel')) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';
$pracownik = null;


if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM pracownicy WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $pracownik = $stmt->fetch();
    
    if (!$pracownik) {
        header('Location: admin_dashboard.php');
        exit;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['zapisz'])) {
    $id = $_POST['id'];
    $imie = trim($_POST['imie']);
    $nazwisko = trim($_POST['nazwisko']);
    $stanowisko = trim($_POST['stanowisko']);
    $email = trim($_POST['email']);
    $telefon = trim($_POST['telefon']);
    $pensja = (float)$_POST['pensja'];
    $data_zatrudnienia = $_POST['data_zatrudnienia'];

 
    if (empty($imie) || empty($nazwisko) || empty($stanowisko)) {
        $error = 'Imię, nazwisko i stanowisko są wymagane!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
        $error = 'Podaj poprawny adres email!';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE pracownicy SET 
                imie = ?, 
                nazwisko = ?, 
                stanowisko = ?, 
                email = ?, 
                telefon = ?, 
                pensja = ?, 
                data_zatrudnienia = ?
                WHERE id = ?");
                
            $stmt->execute([
                $imie,
                $nazwisko,
                $stanowisko,
                $email,
                $telefon,
                $pensja,
                $data_zatrudnienia,
                $id
            ]);
            
            $success = 'Dane pracownika zostały zaktualizowane!';
            $pracownik = $pdo->prepare("SELECT * FROM pracownicy WHERE id = ?")->execute([$id])->fetch();
        } catch (PDOException $e) {
            $error = 'Błąd podczas aktualizacji danych: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj pracownika - Panel Admina</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_dashboard.css" />
</head>
<body>
    <div class="container">
        <h1>Edytuj pracownika</h1>
        
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($pracownik['id']) ?>">
            
            <div class="form-group">
                <label for="imie">Imię:</label>
                <input type="text" id="imie" name="imie" value="<?= htmlspecialchars($pracownik['imie']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="nazwisko">Nazwisko:</label>
                <input type="text" id="nazwisko" name="nazwisko" value="<?= htmlspecialchars($pracownik['nazwisko']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="stanowisko">Stanowisko:</label>
                <input type="text" id="stanowisko" name="stanowisko" value="<?= htmlspecialchars($pracownik['stanowisko']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($pracownik['email']) ?>">
            </div>
            
            <div class="form-group">
                <label for="telefon">Telefon:</label>
                <input type="tel" id="telefon" name="telefon" value="<?= htmlspecialchars($pracownik['telefon']) ?>">
            </div>
            
            <div class="form-group">
                <label for="pensja">Pensja (zł):</label>
                <input type="number" id="pensja" name="pensja" step="0.01" min="0" value="<?= htmlspecialchars($pracownik['pensja']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="data_zatrudnienia">Data zatrudnienia:</label>
                <input type="date" id="data_zatrudnienia" name="data_zatrudnienia" value="<?= htmlspecialchars($pracownik['data_zatrudnienia']) ?>">
            </div>
            
            <div class="form-group">
                <button type="submit" name="zapisz" class="btn">Zapisz zmiany</button>
                <a href="admin_dashboard.php" class="btn btn-secondary">Anuluj</a>
            </div>
        </form>
        
        <a href="admin_dashboard.php" class="back-link">← Powrót do panelu admina</a>
    </div>
</body>
</html>