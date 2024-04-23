<?php ob_start();

$genre = $requeteGenre->fetch();
$films = $requeteFilmsGenre->fetchAll();
$otherFilms = $requeteOtherFilms->fetchAll();
?>

<section id="filmsGenre">

  <p class="subtitle">
    Parcourez les films du genre <?= $genre["nom_genre"] ?> :
  </p>

    <!-- dev prévu pour ajouter un film au genre -->

    <?php
if(!$films) { ?>
    <!-- Si le genre n'a aucun film -->
  </div>
  <p>
    Pas de film dans cette catégorie.
  </p>

  <!-- Si le genre a déja des films -->
  <?php
} else { ?>

  <div class="cards-container">
    <?php foreach ($films as $film) {
        require "templates/filmCard.php";
      } ?>
  </div>
</section>


<?php }
$titre = $genre["nom_genre"];
$titre_secondaire = $genre["nom_genre"];
$contenu = ob_get_clean();
require "templates/template.php";