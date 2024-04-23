<?php ob_start();
$detailFilm = $requeteFilm->fetch();
$genresFilm = $requeteGenres->fetchAll();

?>

<h3 class="title">
  <?=$detailFilm["nom_film"]; ?>
</h3>

<article id="detailFilm">
  <section id="detailFilm-details">
    <p>
      <!-- vérification de l'existance d'un réalisateur -->
      <b>Réalisateur : </b>
      <?php if($detailFilm["rea"]) { ?>
      <span class="link">
        <a href="index.php?action=detailRealisateur&id=<?= $detailFilm["id_realisateur"] ?>">
          <?= $detailFilm["rea"] ?>
        </a>
      </span>
      <?php } else { ?>
      <span>inconnu</span>
      <?php } ?>
    </p>

    <p>
      <b>Date de sortie : </b>
      <span>
        <?= $detailFilm["date_sortie"] ?>
      </span>
    </p>

    <p id="filmGenres">
      <b>Genres : </b>
      <?php
      for($i=0; $i<count($genresFilm); $i++) {
        ?>

      <span class="link">
        <a href="index.php?action=filmsGenre&id=<?= $genresFilm[$i]["id_genre"] ?>">
          <?= $genresFilm[$i]["nom_genre"]; ?>
        </a>
      </span>

      <?php
        if ($i == count($genresFilm)-1) {
          echo ".";
        } else {
          echo "-";
        }
      } ?>
    </p>
  </section>

  <figure id="detailFilm-affiche">
    <img src="<?= $detailFilm["affiche"] ?>" alt="Affiche de <?= $detailFilm["nom_film"] ?>">
    <figcaption class="detailFilm-note">
      <?= $detailFilm["note"] ?>
      <i class="fa-solid fa-star"></i>
    </figcaption>
  </figure>

  <section id="detailFilm-synopsis">
    <p class="synopsis">
      <b>Synopsis : </b> <br>
      <?= $detailFilm["synopsis"] ?>
    </p>
  </section>
</article>

<!-- modif film -->
<!-- ajouter casting -->
<!-- supprimer casting -->

<?php $typeCarrousel = "acteurs";
  require "templates/carrousel.php";
  
$titre = $detailFilm["nom_film"];
$titre_secondaire = $detailFilm["nom_film"];
$contenu = ob_get_clean();
require "templates/template.php";