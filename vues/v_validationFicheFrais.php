<?php
/**
 * Vue validation des fiches de frais 
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

<form method="post" 
              action="index.php?uc=validerFrais&action=validerFicheFrais" 
              role="form">
<input id="ok" type="submit" value="Valider la Fiche de Frais" class="btn btn-success" 
                   role="button">

                   <input type="hidden"
                 name="idVisiteurSelectionne" 
                 id="idVisiteurSelectionne"
                 value="<?php echo $idVisiteurSelectionne?>">
                 <input type="hidden"
                 name="leMoisSelectionne" 
                 id="leMoisSelectionne"
                 value="<?php echo $leMoisSelectionne?>">

</form>
</div>
