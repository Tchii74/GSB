<?php
/**
 * Vue Liste des visiteurs et des mois
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
<div class="row">
    <div class="col-md-4">
        <form action="index.php?uc=validerFrais&action=voirDetailFrais" 
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
        <div class="form-group">
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($lesMois as $unMois) {
                        $lemois = $unMois['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        if ($lemois == $moisASelectionner) {
                            ?>
                            <option selected value="<?php echo $lemois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $lemois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
                </div>
                <h2>Valider la fiche de frais</h2>
                <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
            <input id="annuler" type="reset" value="Effacer" class="btn btn-danger" 
                   role="button">




    </form>
</div>
</div>