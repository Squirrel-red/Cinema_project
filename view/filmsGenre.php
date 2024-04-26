<?php ob_start();

$genre = $requeteGenre->fetch();
$films = $requeteFilmsGenre->fetchAll();
$otherFilms = $requeteOtherFilms->fetchAll();
?>

<section id="filmsGenre">

  <p class="subtitle">
    Parcourez les films du genre <?= $genre["nom_genre"] ?> :
  </p>

  <!--  ajouter un film au genre -->
  <div class='buttons'>
    <a href="index.php?action=creerFilm&genre=<?= $genre["id_genre"] ?>">
      <button class="createButton">créer un film</button>
    </a>

    <div class="addContainer">
      <button class="addButton">ajouter un film</button>

      <!-- insertion des films nonexistants dans la liste -->
      <form id="addFilm" action="index.php?action=ajouterGenreFilm&id=<?= $genre["id_genre"] ?>" method="post">
        <select name="film" required>
          <option selected="true" value="" disabled="disabled">
            Choisissez un film
          </option>
          <?php foreach($otherFilms as $film) { ?>

          <option value="<?= $film["id_film"] ?>">
            <?= $film["nom_film"] ?>
          </option>

          <?php } ?>
        </select>
        <input type="submit" value="valider">
      </form>
    </div>    

    <?php
  if(!$films) { ?>
    <!-- Si le genre n'a aucun film -->

    <p>
      Pas de film dans cette catégorie.
    </p>

    <!-- Si le genre a déja des films -->
    <?php
  } else { ?>
    <div class="removeContainer">
      <button class="removeButton">retirer un film</button>

      <!-- insertion des films existants dans la liste -->
      <form id="removeFilm" action="index.php?action=supprimerGenreFilm&id=<?= $genre["id_genre"] ?>" method="post">
        <select name="film" required>
          <option selected="true" value="" disabled="disabled">
            Choisissez un film
          </option>
          <?php foreach($films as $film) { ?>

          <option value="<?= $film["id_film"] ?>">
            <?= $film["nom_film"] ?>
          </option>

          <?php } ?>
        </select>
        <input type="submit" value="valider">
      </form>
    </div>
  </div>  

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