<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="Cinéma">
  <title><?= $titre ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=M+PLUS+1+Code:wght@100..700&display=swap"
    rel="stylesheet">

  <script src="https://kit.fontawesome.com/7252ea4d54.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>
  <header>

    <a href="index.php?action=accueil">
      <figure id="logo-container">
        <img src="public/img/logo.jpg" alt="logo">
        <figcaption>
          Cinema
        </figcaption>
      </figure>
    </a>


    <div id="search">
      <img src="public/img/wenSearch.png" alt="image loupe de la barre de recherche">
      <input type="search" placeholder="recherchez un film, un acteur, etc.">
    </div>

    <nav>
      <div id="close-button">
        <i class="fa-solid fa-x"></i>
      </div>

      <ul>
        <li class="link"><a href="index.php?action=accueil">Accueil</a></li>
        <li class="link"><a href="index.php?action=listFilms">Films</a></li>
        <li class="link"><a href="index.php?action=listActeurs">Acteurs</a></li>
        <li class="link"><a href="index.php?action=listRealisateurs">Réalisateurs</a></li>
        <li class="link"><a href="index.php?action=listGenres">Genres</a></li>
      </ul>
    </nav>

    <div id="toggle-menu">
      <i class="fa-solid fa-bars"></i>
    </div>


    <a href="#" id="connect-button">
      connexion
    </a>

  </header>

  <div id="wrapper">
    <main>
      <div id="contenu">
        <div id="header-template">
          <h1 class="title">PDO-Cinema</h1>
          <h2 class="subtitle"><?= $titre_secondaire ?></h2>
        </div>

        <hr>

        <?= $contenu ?>
      </div>
    </main>
  </div>

  <footer class="footer">
    <div id="footerContainer">
      <div>
        <a href="#">
          <figure id="logo-container">
            <img src="public/img/logo.jpg" alt="logo">
            <figcaption>
              PDO-Cinema
            </figcaption>
          </figure>
        </a>

        <p id="footerDescription">
          Trouvez votre film favori
        </p>
      </div>

      <div id="contact">
        <h3 class="subtitle">contact</h3>
        <ul class="link">
          <li>
            <a href="#">
              <i class="fa-brands fa-facebook"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa-brands fa-instagram"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa-brands fa-x-twitter"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa-brands fa-discord"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa-brands fa-github"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>

    <p class="copy link">
      &#169; All Rights Reserved By <span id="me"><a href="#">Squirrel-red</a></span>
    </p>
  </footer>

  <?php if(isset($_SESSION["ValidatorMessages"])) {
    foreach($_SESSION["ValidatorMessages"] as $notif) {
        echo $notif;
    }
    unset($_SESSION["ValidatorMessages"]);
} ?>

  <script src="public/js/menuBurger.js"></script>
  <script src="public/js/carrousel.js"></script>
  <script src="public/js/form_add_remove.js"></script>
  <script src="public/js/warningMessage.js"></script>
  <script src="public/js/changeCastingFilm.js"></script>
  <script src="public/js/notif.js"></script>
</body>

</html>