<?php ob_start();
$realisateurs = $requete->fetchAll() ?>

<section id="listRealisateurs">

    <!--créer rea -->
    
    <!-- supprimer rea -->

    <!--lister rea --> 
  <div class="cards-container">

    <?php foreach($realisateurs as $person){
      $type = "realisateur";
      require "templates/personCard.php";
    } ?>

  </div>
</section>
<?php
$titre = "Liste des realisateurs";
$titre_secondaire = "LISTE DES REALISATEURS";
$contenu = ob_get_clean();
require "templates/template.php";