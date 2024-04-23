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

  <!-- ajouter -->
  <!-- supprimer -->


<?php
$titre = "liste genres";
$titre_secondaire = "liste des genres";
$contenu = ob_get_clean();
require "templates/template.php";