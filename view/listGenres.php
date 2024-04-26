<?php ob_start();
$listGenres = $requeteGenres->fetchAll();
?>
<p class="subtitle">Sélectionnez un genre :</p>
<ul id="genres-list">

  <?php foreach($listGenres as $genre){ ?>

  <li class="genre-card">
    <a href="index.php?action=filmsGenre&id=<?= $genre["id_genre"] ?>">
      <?= $genre["nom_genre"]; ?>
    </a>
  </li>
  <?php } ?>
</ul>


  <hr>

<!-- Formulaires Genre -->
<section id="formsGenre">

  <!-- ajouter -->
  <form id="addGenre" action="index.php?action=ajouterGenre" method="post">
    <label for="nom_genre" class="subtitle"> Ajouter un genre </label>
    <input type="text" name="nom_genre" id="nom_genre">
    <input type="submit" value="ajouter" class="buttonForm" />
  </form>

  <!-- supprimer -->
  <form id="removeGenre" class="divWarning" action="index.php?action=supprimerGenre" method="post">
    <label for="genre" class="subtitle"> Supprimer un genre </label>

    <select name="genre" class="warner" id="genres-select">
      <option selected="true" value="" disabled="disabled">
        Choisissez un genre
      </option>

      <?php foreach($listGenres as $genre){ ?>

      <option value="<?= $genre["id_genre"]; ?>">
        <?= $genre["nom_genre"]; ?>
      </option>
      <?php } ?>
    </select>

    <span class="warningMessage warningCache">Attention, supprimer un genre le supprimera de tous les films</span>

    <input type="submit" value="supprimer" class="buttonForm" />
  </form>
</section>


<?php
$titre = "liste genres";
$titre_secondaire = "LISTE DES GENRES";
$contenu = ob_get_clean();
require "templates/template.php";