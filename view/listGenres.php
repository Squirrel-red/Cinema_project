<?php ob_start(); ?>
<p class="uk-label uk-label-warning"> Il y a <?= $requete->rowCount() ?> genres de films dans notre base de données :</p>

<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>N°</th>
            <th>GENRE</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchAll() as $genre) { ?>
                <tr>
                    <td><?= $genre["id"] ?></td>
                    <td><?= $genre["genre"] ?></td>
                </tr>
            <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des genres de films";
$titre_secondaire = "Liste des genres de films";
$contenu = ob_get_clean();
require_once "templates/template.php";