<?php ob_start(); ?>

<p class="uk-label uk-label-warning"> Il y a <?= $requete->rowCount() ?> films triés par genre dans notre base de données :</p>

<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>GENRE</th>
            <th>TITRE</th>
            <th>DATE DE SORTIE</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchAll() as $film_genre) { ?>
                <tr>
                    <td><?= $film_genre["genre"] ?></td>
                    <td><?= $film_genre["titre"] ?></td>
                    <td><?= $film_genre["date"] ?></td>

                </tr>
            <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des films par genre";
$titre_secondaire = "iste des films par genre";
$contenu = ob_get_clean();
require_once "view/template.php";