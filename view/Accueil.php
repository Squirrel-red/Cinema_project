<?php ob_start(); 

$filmFavori = $requeteFilmFavori->fetch();
$acteursFilmFav = $requeteActeursFilmFav->fetchAll();
$filmsMoment = $requeteFilmsMoment->fetchAll();
?>

<!------------------------------------------------>
<!---------------------- UNE --------------------->
<!------------------------------------------------>

<section id="une">
  <h3>À la une</h3>
  <article>

    <!------------- AFFICHE ------------->

    <figure id="afficheFilmFav">
      <a href="index.php?action=detailFilm&id=<?= $filmFavori["id_film"] ?>">
        <img src="<?= $filmFavori["affiche"] ?>" alt="Affiche du film <?= $filmFavori["nom_film"] ?>">
      </a>
    </figure>

    <!-------------- ASIDE -------------->

    <aside>
      <p class="title">
        <?= $filmFavori["nom_film"] ?>
      </p>

      <p class="subtitle">
        un film de
        <span class="link">
          <a href="index.php?action=detailRealisateur&id=<?= $filmFavori["id_realisateur"] ?>">
            <?= $filmFavori["rea"] ?>
          </a>
        </span>
      </p>

      <p class="synopsis">
        <?= $filmFavori["synopsis"] ?>

        <span class="link">
          <a href="index.php?action=detailFilm&id=<?= $filmFavori["id_film"] ?>">
            voir plus ->
          </a>
        </span>
      </p>

      <!-- 2 Acteurs les plus "connus" -->

      <div class="acteurs">
        <p>Avec nos vedettes</p>
        <div class='cards-container'>

          <?php foreach($acteursFilmFav as $person) {
          $type = "acteur";
          require "templates/personCard.php";
          } ?>

        </div>
      </div>

      <!-- Note -->

      <div class="note">
        <?= $filmFavori["note"] ?>
        <i class="fa-solid fa-star"></i>
      </div>
    </aside>
  </article>
</section>

<hr>

<!------------------------------------------------>
<!-------------- DERNIERES SORTIES --------------->
<!------------------------------------------------>

<section id="dernieresSorties">
  <h3>Les dernières sorties</h3>
  <div class=cards-container>
    <?php 
    foreach($filmsMoment as $film) {
   
    require "templates/filmCard.php";
   } ?>
  </div>
</section>

<hr>

<!------------------------------------------------>
<!-------------------- GENRES -------------------->
<!------------------------------------------------>

<section id="genres-accueil">
  <div id="genres-header">
    <h3>Parcourez les genres</h3>
    <span class="link">
      <a href="index.php?action=listGenres">
        voir les genres ->
      </a>
    </span>
  </div>

  <div id="genres-content">

    <!-- Liste des genres de l'accueil -->
    <?php $genresFavoris = [
      "action" => "action",
      "famille" => "film pour enfants",
      "science-fiction" => "science-fiction"];

$filmsAction = $requeteAction->fetchAll();
$filmsFamille = $requeteFamille->fetchAll();
$filmsSf = $requeteSF->fetchAll();

    ////// Un carrousel par genre //////

    foreach($genresFavoris as $key => $value) { 

      switch($key) {
        case 'action':
          $films = $filmsAction;
          break;
        case 'famille':
          $films = $filmsFamille;
          break;
        case 'science-fiction':
          $films = $filmsSf;
          break;
      } ?>

    <article id="accueil-<?= $key ?>">
      <h4>
        Les films du genre
        <span class="link">
          <a href="index.php?action=filmsGenre&id=<?= $films[0]["id_genre"] ?>">
            <?= ucwords($key) ?>
          </a>
        </span> :
      </h4>

      <!-- Intégration du carrousel -->

      <?php $typeCarrousel = "films";
        require "templates/carrousel.php"; 
      ?>
    </article>

    <?php } ?>

</section>

<?php
$titre = "Accueil";
$titre_secondaire = "Trouvez votre film favori";
$contenu = ob_get_clean();
require "templates/template.php";