<?php
/**
 * Vue Liste des visiteurs
 *
 * PHP Version 8
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    Audrey Laval
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>
<h2>Valider la fiche de frais</h2>
<div class="row">
    <div class="col-md-4">
        <form action="index.php?uc=etatFrais&action=voirEtatFrais" 
              method="post" role="form">
            <div class="form-group">
                <label for="lstVisiteur">Choisir le visiteur : </label>
                <select id = "lstVisiteur" name="lstVisiteur" class="form-control">
                    <?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $id = $unVisiteur['id'];
                        $nom = $unVisiteur['nom'];
                        $prenom = $unVisiteur['prenom'];
                    if ($visiteur == $visiteurASelectionner) {
                        ?>
                        <option selected value="<?php echo $visiteur ?>">
                            <?php echo $nom . ' ' . $prenom ?> </option>
                        <?php
                    } else {
                        ?>
                        <option value="<?php echo $visiteur ?>">
                            <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        }
                }
                ?>    

            </select>
        </div>
        
    </form>
</div>
</div>