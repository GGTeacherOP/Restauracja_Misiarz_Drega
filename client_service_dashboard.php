<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Dostęp mają role: obsluga, admin, wlasciciel
if (!in_array($_SESSION['user_role'], ['obsluga', 'admin', 'wlasciciel'])) {
    header('Location: index.php');
    exit;
}

$userName = $_SESSION['user_name'];

// Obsługa formularzy POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Usuwanie opinii
    if (isset($_POST['delete_opinion'])) {
        $opinionId = $_POST['opinion_id'];
        $stmt = $pdo->prepare("DELETE FROM opinie WHERE id = ?");
        $stmt->execute([$opinionId]);
    }

    // Zatwierdzanie opinii
    if (isset($_POST['zatwierdz_opinion'])) {
        $opinionId = $_POST['opinion_id'];
        $stmt = $pdo->prepare("UPDATE opinie SET zatwierdzona = 1 WHERE id = ?");
        $stmt->execute([$opinionId]);
        $_SESSION['success_msg'] = "Opinia została zatwierdzona.";
    }


    // Dodawanie odpowiedzi na pytanie
    if (isset($_POST['answer_question'])) {
        $questionId = $_POST['question_id'];
        $answerText = trim($_POST['answer_text']);

        if ($answerText !== '') {
            $stmt = $pdo->prepare("INSERT INTO odpowiedzi (pytanie_id, uzytkownik_id, tresc, data_dodania) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$questionId, $_SESSION['user_id'], $answerText]);
            $_SESSION['success_msg'] = "Odpowiedź została zapisana.";
        } else {
            $_SESSION['error_msg'] = "Treść odpowiedzi nie może być pusta.";
        }
    }

    // Usuwanie pytania
    if (isset($_POST['delete_question'])) {
    $questionId = $_POST['question_id'];

    // Najpierw usuń odpowiedzi powiązane z pytaniem
    $stmt = $pdo->prepare("DELETE FROM odpowiedzi WHERE pytanie_id = ?");
    $stmt->execute([$questionId]);

    // Następnie usuń pytanie
    $stmt = $pdo->prepare("DELETE FROM pytania WHERE id = ?");
    $stmt->execute([$questionId]);
}

}

// Pobranie opinii i pytań
$opinions = $pdo->query("SELECT id, nazwa_uzytkownika, tresc, data_dodania, zatwierdzona FROM opinie ORDER BY data_dodania DESC")->fetchAll();
$questions = $pdo->query("SELECT p.id, p.email, p.tresc, p.data_dodania, u.nazwa_uzytkownika FROM pytania p LEFT JOIN uzytkownicy u ON p.uzytkownik_id = u.id ORDER BY p.data_dodania DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <title>Panel Obsługi Klienta</title>
    <link rel="stylesheet" href="admin_dashboard.css" />
    <style>
        .answer-form textarea { width: 100%; height: 60px; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Panel Obsługi Klienta</h1>
            <p>Zalogowany jako: <?= htmlspecialchars($userName) ?> (<?= htmlspecialchars($_SESSION['user_role']) ?>)</p>
        </div>
    </div>

    <div class="container">
        <?php if (!empty($_SESSION['success_msg'])): ?>
            <p class="success"><?= htmlspecialchars($_SESSION['success_msg']) ?></p>
            <?php unset($_SESSION['success_msg']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error_msg'])): ?>
            <p class="error"><?= htmlspecialchars($_SESSION['error_msg']) ?></p>
            <?php unset($_SESSION['error_msg']); ?>
        <?php endif; ?>

        <div class="section">
            <h2>Opinie</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Użytkownik</th>
                        <th>Treść</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($opinions as $opinion): ?>
                        <tr>
                            <td><?= htmlspecialchars($opinion['id']) ?></td>
                            <td><?= htmlspecialchars($opinion['nazwa_uzytkownika']) ?></td>
                            <td><?= htmlspecialchars(mb_strimwidth($opinion['tresc'], 0, 50, '...')) ?></td>
                            <td><?= htmlspecialchars($opinion['data_dodania']) ?></td>
                            <td><?= $opinion['zatwierdzona'] ? 'Zatwierdzona' : 'Niezatwierdzona' ?></td>
                            <td>
                                <?php if (!$opinion['zatwierdzona']): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="opinion_id" value="<?= $opinion['id'] ?>">
                                        <button type="submit" name="zatwierdz_opinion" class="btn">Zatwierdź</button>
                                    </form>
                                <?php endif; ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="opinion_id" value="<?= $opinion['id'] ?>">
                                    <button type="submit" name="delete_opinion" class="btn" onclick="return confirm('Czy na pewno chcesz usunąć tę opinię?')">Usuń</button>
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
                        <th>Użytkownik</th>
                        <th>Email</th>
                        <th>Treść pytania</th>
                        <th>Data</th>
                        <th>Odpowiedź</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questions as $question): ?>
                        <tr>
                            <td><?= htmlspecialchars($question['id']) ?></td>
                            <td><?= htmlspecialchars($question['nazwa_uzytkownika'] ?? 'Anonim') ?></td>
                            <td><?= htmlspecialchars($question['email']) ?></td>
                            <td><?= htmlspecialchars(mb_strimwidth($question['tresc'], 0, 50, '...')) ?></td>
                            <td><?= htmlspecialchars($question['data_dodania']) ?></td>
                            <td>
                                <form method="POST" class="answer-form">
                                    <input type="hidden" name="question_id" value="<?= $question['id'] ?>">
                                    <textarea name="answer_text" placeholder="Twoja odpowiedź..."></textarea><br>
                                    <button type="submit" name="answer_question" class="btn">Odpowiedz</button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="question_id" value="<?= $question['id'] ?>">
                                    <button type="submit" name="delete_question" class="btn" onclick="return confirm('Czy na pewno chcesz usunąć to pytanie?')">Usuń</button>
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
