<?php ob_start();
$detailFilm = $requeteFilm->fetch();
$genresFilm = $requeteGenres->fetchAll();
$acteurs = $requeteActeurs->fetchAll();
$acteursAll = $requeteActeursAll->fetchAll();

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
    <img src="<?= $detailFilm["affiche_film"] ?>" alt="Affiche de <?= $detailFilm["nom_film"] ?>">
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

<div class="buttons">
  <a href="index.php?action=modifFilmForm&id=<?= $detailFilm["id_film"] ?>">
    <button>
      <i class="fa-solid fa-pen editButton"></i>
      modifier les infos
    </button>
  </a>
</div>

<hr>

<h4>Les acteurs :</h4>

<!-- ajouter casting -->
<div class="addContainer">
    <button class="addButton">ajouter un casting</button>

    <form id="addCasting" action="index.php?action=creerCastingFilm&id=<?= $detailFilm["id_film"] ?>" method="post">

      <!-- choix acteur -->
      <select name="acteur" required>
        <option selected="true" value="" disabled="disabled">
          Choisissez un acteur
        </option>
        <?php foreach($acteursAll as $acteur) { ?>

        <option value="<?= $acteur["id_acteur"] ?>">
          <?= $acteur["fullName"] ?>
        </option>
        <?php } ?>
      </select>

      <!-- choix role -->
      <div id="castingRole">
        <label for="role">Quel rôle joué ?</label>
        <input type="text" id="role" name="role" required>
      </div>

      <input type="submit" value="valider">
    </form>
  </div>
<!-- supprimer casting -->
<div class="removeContainer">
    <button class="removeButton">retirer un casting</button>

    <form id="removeCasting" class="divWarning"
      action="index.php?action=supprimerCastingFilm&id=<?= $detailFilm["id_film"] ?>" method="post">
      <select name="role" class="warner" required>
        <option selected="true" value="" disabled="disabled">
          Choisissez un role
        </option>
        <?php foreach($acteurs as $casting) { ?>

        <option value="<?= $casting["id_role"] ?>">
          <?= $casting["nom_role"] ?>
        </option>

        <?php } ?>
      </select>
      <span class="warningMessage warningCache">Supprimer ce casting?</span>
      <input type="submit" value="valider">
    </form>
  </div>
</div>
<?php $typeCarrousel = "acteurs";
  require "templates/carrousel.php";
  
$titre = $detailFilm["nom_film"];
$titre_secondaire = $detailFilm["nom_film"];
$contenu = ob_get_clean();
require "templates/template.php";