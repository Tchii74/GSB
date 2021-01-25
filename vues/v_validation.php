<?php
/**
 * Vue Validation
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
<div class="alert validation-modif" role="alert">
    <?php
    foreach ($_REQUEST['message'] as $valide) {
        echo '<p>' . htmlspecialchars($valide) . '</p>';
    }
    ?>

</div>