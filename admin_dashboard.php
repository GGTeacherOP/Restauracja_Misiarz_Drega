<?php
session_start();
require_once 'db_config.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'wlasciciel') {
    header('Location: index.php');
    exit;
}


$isOwner = ($_SESSION['user_role'] === 'wlasciciel');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if ($isOwner && isset($_POST['delete_user'])) {
        $userId = $_POST['user_id'];
        $stmt = $pdo->prepare("DELETE FROM uzytkownicy WHERE id = ?");
        $stmt->execute([$userId]);
    }
    
    
    if (isset($_POST['delete_reservation'])) {
        $reservationId = $_POST['reservation_id'];
        $stmt = $pdo->prepare("DELETE FROM rezerwacje WHERE id = ?");
        $stmt->execute([$reservationId]);
    }
    
   
    if (isset($_POST['delete_opinion'])) {
        $opinionId = $_POST['opinion_id'];
        $stmt = $pdo->prepare("DELETE FROM opinie WHERE id = ?");
        $stmt->execute([$opinionId]);
    }
    
    
    if (isset($_POST['delete_question'])) {
        $questionId = $_POST['question_id'];
        $stmt = $pdo->prepare("DELETE FROM pytania WHERE id = ?");
        $stmt->execute([$questionId]);
    }
    
  
    if ($isOwner && isset($_POST['promote_to_admin'])) {
        $userId = $_POST['user_id'];
        $stmt = $pdo->prepare("UPDATE uzytkownicy SET uprawnienia = 'admin' WHERE id = ?");
        $stmt->execute([$userId]);
    }
}
if (isset($_POST['delete_pracownik'])) {
    $pracownikId = $_POST['pracownik_id'];
    $stmt = $pdo->prepare("DELETE FROM pracownicy WHERE id = ?");
    $stmt->execute([$pracownikId]);
    $_SESSION['success_msg'] = "Pracownik został usunięty";
    header("Location: admin_dashboard.php");
    exit;
}


$users = $pdo->query("SELECT * FROM uzytkownicy")->fetchAll();
$reservations = $pdo->query("SELECT * FROM rezerwacje")->fetchAll();
$opinions = $pdo->query("SELECT * FROM opinie")->fetchAll();
$questions = $pdo->query("SELECT * FROM pytania")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admina</title>
    <link rel="stylesheet" href="admin_dashboard.css" />
</head>
<body>
   <div class="header">
        <div class="container">
            <h1><?= $isOwner ? 'Panel Właściciela' : 'Panel Admina' ?></h1>
            <p>Zalogowany jako: <?= htmlspecialchars($_SESSION['user_name']) ?> (<?= htmlspecialchars($_SESSION['user_role']) ?>)</p>
        </div>
    </div>

    <div class="container">
        <?php if ($isOwner): ?>
        <div class="section owner-only">
            <h2>Zarządzanie Użytkownikami</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Email</th>
                        <th>Uprawnienia</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['imie']) ?></td>
                        <td><?= htmlspecialchars($user['nazwisko']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['uprawnienia']) ?></td>
                        <td>
                            <?php if ($user['uprawnienia'] === 'uzytkownik'): ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button type="submit" name="promote_to_admin" class="btn promote-btn">Awansuj na admina</button>
                            </form>
                            <?php endif; ?>
                            
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button type="submit" name="delete_user" class="btn" 
                                    onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?')">Usuń</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <div class="section">
            <h2>Rezerwacje</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Data</th>
                        <th>Godzina</th>
                        <th>Ilość osób</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['id']) ?></td>
                        <td><?= htmlspecialchars($reservation['imie']) ?></td>
                        <td><?= htmlspecialchars($reservation['nazwisko']) ?></td>
                        <td><?= htmlspecialchars($reservation['data']) ?></td>
                        <td><?= htmlspecialchars($reservation['godzina']) ?></td>
                        <td><?= htmlspecialchars($reservation['ilosc_osob']) ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="reservation_id" value="<?= $reservation['id'] ?>">
                                <button type="submit" name="delete_reservation" class="btn">Usuń</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Opinie</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imię</th>
                        <th>Treść</th>
                        <th>Data</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($opinions as $opinion): ?>
                    <tr>
                        <td><?= htmlspecialchars($opinion['id']) ?></td>
                        <td><?= htmlspecialchars($opinion['nazwa_uzytkownika']) ?></td>
                        <td><?= htmlspecialchars(substr($opinion['tresc'], 0, 50)) ?>...</td>
                        <td><?= htmlspecialchars($opinion['data_dodania']) ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="opinion_id" value="<?= $opinion['id'] ?>">
                                <button type="submit" name="delete_opinion" class="btn">Usuń</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Pytania od klientów</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imię</th>
                        <th>Email</th>
                        <th>Treść</th>
                        <th>Data</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questions as $question): ?>
                    <tr>
                        <td><?= htmlspecialchars($question['id']) ?></td>
                        <td><?= htmlspecialchars($question['imie']) ?></td>
                        <td><?= htmlspecialchars($question['email']) ?></td>
                        <td><?= htmlspecialchars(substr($question['tresc'], 0, 50)) ?>...</td>
                        <td><?= htmlspecialchars($question['data_dodania']) ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="question_id" value="<?= $question['id'] ?>">
                                <button type="submit" name="delete_question" class="btn">Usuń</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="section">
    <h2>Pracownicy</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Stanowisko</th>
                <th>Pensja</th>
                <th>Kontakt</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $pracownicy = $pdo->query("SELECT * FROM pracownicy ORDER BY stanowisko, nazwisko")->fetchAll();
            foreach ($pracownicy as $pracownik): ?>
            <tr>
                <td><?= htmlspecialchars($pracownik['id']) ?></td>
                <td><?= htmlspecialchars($pracownik['imie']) ?></td>
                <td><?= htmlspecialchars($pracownik['nazwisko']) ?></td>
                <td><?= htmlspecialchars($pracownik['stanowisko']) ?></td>
                <td><?= number_format($pracownik['pensja'], 2, ',', ' ') ?> zł</td>
                <td>
                    <?= htmlspecialchars($pracownik['email']) ?><br>
                    <?= htmlspecialchars($pracownik['telefon']) ?>
                </td>
                <td>
                    <a href="edytuj_pracownika.php?id=<?= $pracownik['id'] ?>" class="btn" style="background-color:#17a2b8;">Edytuj</a>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="pracownik_id" value="<?= $pracownik['id'] ?>">
                        <button type="submit" name="delete_pracownik" class="btn" 
                            onclick="return confirm('Czy na pewno chcesz usunąć tego pracownika?')">Usuń</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

        <a href="index.php" class="back-btn">Powrót do strony głównej</a>
    </div>
</body>
</html>