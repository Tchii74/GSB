<?php
/**
 * Vue Liste des visiteurs pour "Suivre paiement des fiches de frais"
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
<h2>Suivre paiement des fiches de frais</h2>
<div class="row">
    <div class="col-md-4">
        <form action="index.php?uc=suivreFrais&action=voirMoisSuivrePaiement" 
              method="post" role="form">
            <div class="form-group">
            <label for="lstVisiteur">Choisir le visiteur : </label>
                <select id = "lstVisiteur" name="lstVisiteur" class="form-control">
                    <?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $id = $unVisiteur['id'];
                        $nom = $unVisiteur['nom'];
                        $prenom = $unVisiteur['prenom'];
                    if ($unVisiteur['id'] == $visiteurASelectionner) {
                        ?>
                        <option selected value="<?php echo $id?>">
                            <?php echo $nom . ' ' . $prenom ?> </option>
                        <?php
                    } else {
                        ?>
                        <option value="<?php echo $id ?>">
                            <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        }
                }
                ?>    
            </select>
            </div>
        

        
                <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
    </form>
</div>
</div>