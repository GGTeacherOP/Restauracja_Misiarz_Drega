<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu - Restauracja Kraftowa</title>
  <link rel="stylesheet" href="menu.css">
</head>
<body>

  <nav class="nav-bar">
    <ul class="nav-links">
      <li><a href="index.php">Strona główna</a></li>
      <li><a href="index.php">O nas</a></li>
      <li><a href="index.php">Promocje</a></li>
      <li><a href="index.php">Galeria</a></li>
      <li><a href="index.php">Opinie</a></li>
      <li><a href="index.php">Kontakt</a></li>
    </ul>
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="user-menu">
        <span>Witaj, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
        <a href="logout.php" class="logout-button">Wyloguj</a>
    </div>
<?php else: ?>
    <a href="login.php"><button class="login-button">Zaloguj się</button></a>
<?php endif; ?>
  </nav>

  <main>
    <h1 class="menu-title">Nasze Menu</h1>

  <h2 class="section-heading">Dania główne</h2>
  <div class="menu-container">

    <div class="dish">
      <img src="https://www.winiary.pl/sites/default/files/styles/home_stage_944_531/public/srh_recipes/8aa813f790fac0f4f805fdaa650e2b0c.jpg?h=6acbff97&itok=-V4XJVzB" alt="Burger">
      <h3>Burger Kraftowy</h3>
      <p class="description">bułka brioche, 2x 180g wołowiny, podwójny bekon, ser mimolette, cebulka prażona, krążki cebulowe, sos mayo, sos musztardowy</p>
      <p class="price">70,00 zł</p>
    </div>

    <div class="dish">
      <img src="https://www.gardengourmet.com/sites/default/files/recipes/cd69f47414565ae76769b93398728fd7_221004_gg_american-bbq-style-burger_recept.jpg" alt="Burger">
      <h3>Burger BBQ</h3>
      <p class="description">wołowina 180 g, bekon, ser cheddar, cebula karmelizowana, ogórek konserwowy, sałata, sos BBQ, majonez, bułka maślana</p>
      <p class="price">47,00 zł</p>
    </div>

    <div class="dish">
      <img src="https://gotujezlewiatanem.pl/wp-content/uploads/2022/05/AdobeStock_258433064-kopia.jpeg" alt="Burger Ostry">
      <h3>Burger Ostry Maciuś</h3>
      <p class="description">bułka brioche, 180g wołowiny, ser mimolette, bekon, mix sałat, papryczki jalapeño, czerwona cebula, pikle, sos mayo, ostry sos</p>
      <p class="price">56,00 zł</p>
    </div>

    <div class="dish">
      <img src="https://www.sargento.com/assets/Uploads/Recipe/Image/GreatAmericanBurger__FocusFillWyIwLjAwIiwiMC4wMCIsMTEwMCw2NTdd.jpg" alt="Cheeseburger">
      <h3>Cheeseburger</h3>
      <p class="description">bułka brioche, kawałki kurczaka w panierce, mix sałat, pomidor, pikle, czerwona cebula, ser mimolette, sos mayo</p>
      <p class="price">40,00 zł</p>
    </div>

    <div class="dish">
      <img src="https://lp.tvokazje.pl/wp-content/uploads/2023/06/Pieczone-zeberka-scaled.jpeg" alt="Żeberka BBQ">
      <h3>Żeberka BBQ</h3>
      <p class="description">żeberka marynowane w BBQ, ćwiartki ziemniaczane, czerwona kapusta, sałatka wiosenna</p>
      <p class="price">58,00 zł</p>
    </div>

    <div class="dish">
      <img src="https://uwielbiam.pl/_next/image?url=https%3A%2F%2Fsaproduwielbiaplmmedia.blob.core.windows.net%2Fmedia%2Frecipes%2Fimages%2F8307-1702058032942.jpeg&w=2048&q=75" alt="Tradycyjne Żeberka w Cebul">
      <h3>Tradycyjne Żeberka w Cebul</h3>
      <p class="description">żeberko duszone w warzywach, ziemniaki, cebulka duszona, surówka</p>
      <p class="price">58,00 zł</p>
    </div>

    <div class="dish">
      <img src="https://i.ytimg.com/vi/RNgXVmIj3Sw/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLAULurEd7u84HcZGMP9TikEjm_OaQ" alt="Spaghetti alla Carbonara">
      <h3>Spaghetti alla Carbonara</h3>
      <p class="description">tradycyjny włoski przepis z żółtkami, pecorino romano, guanciale i pieprzem</p>
      <p class="price">41,00 zł</p>
    </div>

    <div class="dish">
      <img src="https://www.allrecipes.com/thmb/nO3iistRRBHuMCz1Gr_0XuMGaWg=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/ALR-8513545-penne-alla-vodka-VAT-hero-4x3-2-4a53c968c3d94a32816f01f5793702ce.jpg" alt="Penne alla Vodka">
      <h3>Penne alla Vodka</h3>
      <p class="description">sos pomidorowo-śmietanowy z nutą wódki, czosnkiem i płatkami chili, wykończony parmezanem</p>
      <p class="price">38,00 zł</p>
    </div>

    <div class="dish">
      <img src="https://www.winiary.pl/sites/default/files/styles/srh_recipes/public/srh_recipes/b76bc0e633163dc08fc20dbd5b67af9c.jpg?h=06ac0d8c&itok=CJcKP7NX" alt="Makaron Pappardelle z Kurczakiem">
      <h3>Makaron Pappardelle z Kurczakiem</h3>
      <p class="description">makaron pappardelle, sos śmietanowy, kurczak, suszone pomidory</p>
      <p class="price">42,00 zł</p>
    </div>

    <div class="dish">
      <img src="https://res.cloudinary.com/norgesgruppen/images/c_scale,dpr_auto,f_auto,q_auto:eco,w_1600/axcdfcfmyahxjmmj99pe/pizza-diavola" alt="Pizza Diavola">
      <h3>Pizza Diavola</h3>
      <p class="description">sos pomidorowy, mozzarella, pikantne salami spianata, papryczki jalapeño, oliwki, oregano</p>
      <p class="price">45,00 zł</p>
    </div>

    <div class="dish">
      <img src="https://www.nestleprofessional.de/sites/default/files/styles/np_recipe_detail/public/srh_recipes/6deabf048ef9fcb4b4af1186a2e80d6b.jpg?itok=mO92fU70" alt="Pizza Primavera">
      <h3>Pizza Primavera</h3>
      <p class="description">pomidory pelati, mozzarella fior di latte, pieczarki, pancetta, salami pepperoni, świeży czosnek</p>
      <p class="price">44,00 zł</p>
    </div>

    <div class="dish">
      <img src="https://salsiccia.pl/wp-content/uploads/2017/09/tn_2019.09.13_pizza_salsiccia_19.jpg" alt="Pizza Salsiccia">
      <h3>Pizza Salsiccia</h3>
      <p class="description">sos pomidorowy, mozzarella, włoska kiełbasa salsiccia, papryka, cebula, czosnek, rukola</p>
      <p class="price">45,00 zł</p>
    </div>

    <div class="dish">
      <img src="https://www.unileverfoodsolutions.pl/dam/global-ufs/mcos/NEE/calcmenu/recipes/PL-recipes/pasta-dishes/pizza-parma/main-header.jpg" alt="Pizza Parma">
      <h3>Pizza Parma</h3>
      <p class="description">sos śmietanowy, mozzarella fior di latte, rukola, pomidory cherry, prosciutto di parma, parmezan</p>
      <p class="price">45,00 zł</p>
    </div>

  </div>

  <h2 class="section-heading">Napoje</h2>
  <div class="menu-container">

    <div class="dish">
      <h3>Piwo Kraftowe</h3>
      <p class="description">Rzemieślnicze piwo warzone lokalnie – różne style do wyboru 0,5l</p>
      <p class="price">16 zł</p>
    </div>

    <div class="dish">
      <h3>Woda Mineralna</h3>
      <p class="description">Do wyboru gazowana lub niegazowana 0,4l</p>
      <p class="price">8 zł</p>
    </div>

    <div class="dish">
      <h3>Cola / Fanta / Sprite</h3>
      <p class="description">Napój gazowany 0,3l</p>
      <p class="price">10 zł</p>
    </div>
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

</body>
</html>
