<?php ob_start();
$acteurs = $requete->fetchAll();
?>
<section id="listActeurs">

    <!-- ajouter acteur -->

    <!-- supprimer acteur -->

    <!-- lister acteurs  -->
  <div class="cards-container">

    <?php foreach($acteurs as $person){
      $type = "acteur";

require "templates/personCard.php";
} ?>
  </div>
</section>

<?php
$titre = "Liste des acteurs";
$titre_secondaire = "Liste des acteurs";
$contenu = ob_get_clean();
require "templates/template.php";