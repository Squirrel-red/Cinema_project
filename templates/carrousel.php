<div class="carroussel">
  <i class="fa-solid fa-circle-arrow-left arrow arrow-left"></i>

  <div class="carroussel-wrapper">
    <div class="cards-container">
      <?php switch($typeCarrousel) {

        case "films" :

          // Carrousel Films
          foreach( $films as $film) {
            
            require "templates/filmCard.php";
          }
          break;

        case "acteurs" :

          // Carrousel Acteurs
          foreach( $acteurs as $person) { 
            $type = "acteur";
            ?>

      <div class="acteurCard">
        <!-- import cartes -->
        <div class="acteurFigure">
          <?php require "templates/personCard.php"; ?>
        </div>
        <div class="castingRole">
          <p>Dans le rôle de :</p>
          <p class="subtitle"><?= $person["nom_role"] ?></p>
        </div>
        <i class="fa-solid fa-pen editButton"></i>
      </div>

      <?php } 
          break;
        } ?>
    </div>
  </div>

  <i class="fa-solid fa-circle-arrow-right arrow arrow-right"></i>
</div>