<?php ob_start(); ?>

<p class="uk-label uk-label-warning"> Voici <?= $requete->rowCount() ?> acteurs dans notre base de données qui ont joué dans les films suivants: :</p>

<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>N°</th>
            <th>ACTEUR</th>
            <th>TITRE DU FILM</th>
            <th>ROLE</th>           
            <th>QUI EST CETTE PERSONNE</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchAll() as $acteur_film) { ?>
                <tr>
                    <td><?= $acteur_film["id"] ?></td>
                    <td><?= $acteur_film["personne"] ?></td>
                    <td><?= $acteur_film["titre"] ?></td>
                    <td><?= $acteur_film["personnage"] ?></td>                    
                    <td><?= $acteur_film["profil"] ?></td>

                </tr>
            <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des acteurs/actrices par film";
$titre_secondaire = "Liste des acteurs/actrices par film";
$contenu = ob_get_clean();
require_once "templates/template.php";