<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Restauracja Kraftowa</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <div id="loginModal" class="modal">
  <div class="modal-content">
    <h2>Wymagane logowanie</h2>
    <p>Aby złożyć zamówienie, musisz się najpierw zalogować.</p>
    <div class="modal-buttons">
      <a href="login.php?redirect=zamowienie.php" class="login-btn">Zaloguj się</a>
      <a href="#" class="cancel-btn" onclick="document.getElementById('loginModal').style.display='none'">Anuluj</a>
    </div>
  </div>
</div>
  <main>
  <?php
session_start();
require_once 'db_config.php';


if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE remember_token = ? AND token_expiry > NOW()");
        $stmt->execute([$_COOKIE['remember_token']]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['imie'] . ' ' . $user['nazwisko'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['uprawnienia'];
            
           
            $newToken = bin2hex(random_bytes(32));
            $newExpiry = time() + 60 * 60 * 24 * 30;
            
            $stmt = $pdo->prepare("UPDATE uzytkownicy SET remember_token = ?, token_expiry = ? WHERE id = ?");
            $stmt->execute([$newToken, date('Y-m-d H:i:s', $newExpiry), $user['id']]);
            
            setcookie('remember_token', $newToken, $newExpiry, '/', '', true, true);
        } else {
          
            setcookie('remember_token', '', time() - 3600, '/');
        }
    } catch (PDOException $e) {
        error_log("Auto-login error: " . $e->getMessage());
    }
}


?>
  <nav class="nav-bar">
    <ul class="nav-links">
        <li><a href="menu.php">Menu</a></li>
        <li><a href="#onas">O nas</a></li>
        <li><a href="#promocje">Promocje</a></li>
        <li><a href="#galeria">Galeria</a></li>
        <li><a href="#opinie">Opinie</a></li>
        <li><a href="#kontakt">Kontakt</a></li>
        <li><a href="rezerwacja.php">Rezerwacja</a></li>
    </ul>
<?php if (isset($_SESSION['user_id'])): ?>
<div class="user-menu">
    <span>Witaj, <?= htmlspecialchars($_SESSION['user_name']) ?></span>

    <?php
    // Pokazuje odpowiedni link panelu w zależności od roli
    if ($_SESSION['user_role'] === 'wlasciciel'): ?>
        <a href="wlasciciel_panel.php" class="panel-button">Panel Właściciela</a>
    <?php elseif ($_SESSION['user_role'] === 'admin'): ?>
        <a href="admin_dashboard.php" class="panel-button">Panel Admina</a>
    <?php elseif ($_SESSION['user_role'] === 'obsluga'): ?>
        <a href="client_service_dashboard.php" class="panel-button">Panel Obsługi Klienta</a>
    <?php endif; ?>

    <a href="logout.php" class="logout-button">Wyloguj</a>
</div>
<?php else: ?>
    <a href="login.php"><button class="login-button">Zaloguj się</button></a>
<?php endif; ?>

</nav>

  <header class="hero">
  <div class="overlay">
    <h1>Poznaj Smak Kraftowych Dań!</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="zamowienie.php" class="btn">Zamów Online</a>
    <?php else: ?>
      <button class="btn" onclick="document.getElementById('loginModal').style.display='block'">Zamów Online</button>
    <?php endif; ?>
  </div>
</header>

  <section id="onas">
    <div class="about-section">
    <div class="about-overlay">
      <h2>O nas</h2>
      <p>
        Jesteśmy lokalną restauracją kraftową, serwującą unikalne piwa oraz potrawy inspirowane tradycją i nowoczesnością.
        Tworzymy miejsce z pasją, w którym łączymy regionalne składniki z autorskimi recepturami, a każde danie i każdy kufel opowiadają własną historię.
        Naszym celem jest nie tylko karmienie – chcemy dostarczać wyjątkowych doznań kulinarnych w ciepłej, przyjaznej atmosferze, gdzie każdy gość czuje się jak u siebie.
      </p>
    </div>
    </div>
  </section>  

  <section id="promocje">
    <h1>Promocje</h1>
    <div class="promo-box">
      <h3>Happy Hours -20%</h3>
      <p>Codziennie od 14:00 do 17:00 – wszystkie pizze i burgery 20% taniej!</p>
    </div>
    <div class="promo-box-extra">
      <h3>Weekendowe Kombo</h3>
      <p>W każdy weekend: 2 pizze + 2 napoje za jedyne 85,00zł!</p>
    </div>
  </section>
  <section id="galeria">
    <h1>Galeria</h1>
    <div class="gallery">
      <img src="https://az.przepisy.pl/www-przepisy-pl/www.przepisy.pl/przepisy3ii/img/variants/800x0/zeberka-pieczone-w-sosie-wlasnym.jpg" alt="Żeberka" class="miniatura"/>
      <img src="https://assets.epicurious.com/photos/5c745a108918ee7ab68daf79/1:1/w_2560%2Cc_limit/Smashburger-recipe-120219.jpg" alt="Burger" class="miniatura"/>
      <img src="https://www.winiary.pl/sites/default/files/styles/srh_recipes/public/srh_recipes/b76bc0e633163dc08fc20dbd5b67af9c.jpg?h=06ac0d8c&itok=CJcKP7NX" alt="Makaron" class="miniatura"/>
      <img src="https://pizzababilon.pl/wp-content/uploads/pizza-rzymska-z-czym-jest-i-jak-j-zrobi.jpg" alt="Pizza" class="miniatura"/>
      <img src="https://gotujezlewiatanem.pl/wp-content/uploads/2022/05/AdobeStock_258433064-kopia.jpeg" alt="Burger" class="miniatura"/>
      <img src="https://api.broilking.pl/api/media/c/public/crop/1050/688/2/13/fp/images/przepisy/przepis-na-zeberka-z-grilla-w-miodowej-glazurze/przepis-na-zeberka-z-grilla-w-miodowej-glazurze-01.jpg" alt="Żeberka" class="miniatura"/>
      <img src="https://static.wiadomoscihandlowe.pl/images/2023/07/10/o_486060_1280.webp" alt="Piwo" class="miniatura"/>
      <img src="https://www.horecabc.pl/wp-content/uploads/2022/02/pizza3.webp" alt="Pizza" class="miniatura"/>
      <img src="https://cdn.wyjatkowyprezent.pl/storage/photos/products/125298/114410.jpg?w=2000&h=2000" alt="Burger" class="miniatura"/>
      <img src="https://winnicalidla.pl/media/amasty/blog/magpleasure/mpblog/upload/9/0/900ec11a0faa99de1980fd0fe1a1e8bd.jpg" alt="Piwo" class="miniatura"/>
      <img src="https://res.cloudinary.com/norgesgruppen/images/c_scale,dpr_auto,f_auto,q_auto:eco,w_1600/axcdfcfmyahxjmmj99pe/pizza-diavola" alt="Pizza" class="miniatura"/>
      <img src="https://www.allrecipes.com/thmb/nO3iistRRBHuMCz1Gr_0XuMGaWg=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/ALR-8513545-penne-alla-vodka-VAT-hero-4x3-2-4a53c968c3d94a32816f01f5793702ce.jpg" alt="Pizza" class="miniatura"/>
      <img src="https://www.gardengourmet.com/sites/default/files/recipes/cd69f47414565ae76769b93398728fd7_221004_gg_american-bbq-style-burger_recept.jpg" alt="Pizza" class="miniatura"/>
    </div>
    <div class="popup" id="popup">
      <span class="close" id="close">&times;</span>
      <img src="" alt="Powiększenie" id="popup-img">
    </div>
  </section>

<section id="opinie">
  <h1>Opinie</h1>
  <div class="opinie-container">
    <?php
    $conn = new mysqli("localhost", "root", "", "restauracja");

    if ($conn->connect_error) {
      echo "<p>Błąd połączenia z bazą danych.</p>";
    } else {
      $sql = "SELECT nazwa_uzytkownika, tresc, data_dodania FROM opinie ORDER BY id DESC LIMIT 10";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo '<div class="opinie-item">';
          echo '<img src="https://ufrsante.uidt.sn/wp-content/uploads/2023/09/default-avatar-profile-icon-vector-social-media-user-photo-700-205577532.jpg" alt="Avatar" />';
          echo '<div class="user-comment">';
          echo '<strong>' . htmlspecialchars($row["nazwa_uzytkownika"]) . '</strong>';
          echo '<blockquote>' . htmlspecialchars($row["tresc"]) . '</blockquote>';
          echo '<small style="color:gray;">Dodano: ' . date("d.m.Y", strtotime($row["data_dodania"])) . '</small>';
          echo '</div>';
          echo '</div>';
        }
      } else {
        echo "<p>Brak jeszcze opinii.</p>";
      }

      $conn->close();
    }
    ?>
  </div>
    <?php if (isset($_SESSION['user_id'])): ?>
      <div class="link-opinia">
        <a href="dodaj_opinie.php">➕ Dodaj swoją opinię</a>
      </div>
    <?php else: ?>
        <p class="logowanie-opinia">Aby dodać opinię, <a href="login.php?redirect=index.php#opinie">zaloguj się</a>.</p>
    <?php endif; ?>
</section>

  <section id="kontakt">
  <h1>Masz pytania? Napisz do nas</h1>

  <form action="kontakt.php" method="post">
    <input type="text" name="name" placeholder="Twoje imię" required>
    <input type="email" name="email" placeholder="Twój email" required>
    <textarea name="message" placeholder="Zadaj pytanie do restauracji" required></textarea>
    <button type="submit">Wyślij</button>
  </form>

  <div class="map">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2442.234175297988!2d21.00567821579256!3d52.25189567976538!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471ecd76fcb419a5%3A0xd177e5a6c30d0fc!2sUlica+Kwiatowa+12%2C+Warszawa!5e0!3m2!1spl!2spl!4v1680000000000!5m2!1spl!2spl" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
  </div>
</section>

  </main> 

  <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h4>Kontakt</h4>
        <p>Restauracja Kraftowa</p>
        <p>ul. Kwiatowa 12, Warszawa</p>
        <p>Tel: 123 456 789</p>
        <p>Email: kontakt@kraftowa.pl</p>
      </div>
      <div class="footer-section">
        <h4>Godziny otwarcia</h4>
        <p>Pon - Pt: 12:00 - 22:00</p>
        <p>Sob - Niedz: 13:00 - 23:00</p>
      </div>
      <div class="footer-section">
        <h4>Znajdź nas</h4>
        <div class="socials">
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook"></a>
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733558.png" alt="Instagram"></a>
          <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" alt="Twitter"></a>
        </div>
      </div>
    </div>
    <div class="copyright">
      <p>&copy; 2025 Restauracja Kraftowa. Wszelkie prawa zastrzeżone.</p>
    </div>
  </footer>

  <script>
  const popup = document.getElementById('popup');
  const popupImg = document.getElementById('popup-img');
  const closeBtn = document.getElementById('close');

  document.querySelectorAll('.miniatura').forEach(img => {
    img.addEventListener('click', () => {
      popupImg.src = img.src;
      popup.classList.add('show');
    });
  });

  closeBtn.addEventListener('click', () => {
    popup.classList.remove('show');
  });

  popup.addEventListener('click', (e) => {
    if (e.target === popup) {
      popup.classList.remove('show');
    }
  });

  document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector('form[action="kontakt.php"]');

  if (form) {
    form.addEventListener("submit", function (e) {
      const name = form.name.value.trim();
      const email = form.email.value.trim();
      const message = form.message.value.trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      let errors = [];

      if (name === "") {
        errors.push("Imię jest wymagane.");
      }

      if (!emailRegex.test(email)) {
        errors.push("Wprowadź poprawny adres e-mail.");
      }

      if (message === "") {
        errors.push("Treść wiadomości jest wymagana.");
      }

      if (errors.length > 0) {
        e.preventDefault(); // Zatrzymaj wysyłanie formularza
        alert(errors.join("\n"));
      }
    });
  }

  // 🔔 Alert po przesłaniu formularza
  const params = new URLSearchParams(window.location.search);
  if (params.get("success") === "1") {
    alert("Twoje pytanie zostanie rozpatrzone, a odpowiedź wysłana na email.");
    history.replaceState(null, "", window.location.pathname + "#kontakt");
  }
});
</script>

</body>
</html> 