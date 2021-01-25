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
    <div class ="span3">
        <div class="col-md-4">
            <div class = "control-group">
                <form action="index.php?uc=suivreFrais&action=voirFrais" 
                    method="post" role="form">
                    <?php
                    $lesVisiteurs;
                    $lesMois;
                    $lesMoisParVisiteur=array();
              
                    foreach ($lesMois as $unMois)
                    {
                        $lesMoisParVisiteur[$unMois['idvisiteur']][$unMois['mois']] = $unMois['mois'];
                    }?>    
                    </select>
                        <div class="form-group">
                        <label for="lstVisiteur">Choisir le visiteur : </label>
                            <select id = "lstVisiteur" name="Visiteur" class="form-control" onload ="myfunction()" onchange="myfunction()">
                                <?php
                                foreach ($lesVisiteurs as $unVisiteur) {
                                $id = $unVisiteur['id'];
                                $nom = $unVisiteur['nom'];
                                $prenom = $unVisiteur['prenom'];
                                    if ($unVisiteur['id'] == $visiteurASelectionner) {?>
                                        <option selected value="<?php echo $id?>">
                                            <?php echo $nom . ' ' . $prenom ?> </option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?php echo $id ?>">
                                            <?php echo $nom . ' ' . $prenom ?> </option>
                                            <?php
                                        }
                                    }?>    
                            </select>
                        </div>
                    </select>
                    <div class ="span3">
                        <div class = "control-group">
                        <label for="lstMois">Choisir le mois : </label>
                            <?php
                           
                            $tousLesId =array();
                            foreach ($lesMoisParVisiteur as $key =>$moisduVisiteur): 
                            $tousLesId[]= "$key";
                            $id = $key;
                             ?>                                
                            <select id = "<?= $id; ?>" name = "<?= $id; ?>" class ="form-control mois" style=  "<?php if ($id == $visiteurASelectionner)
                                                                 {
                                                                    echo "visibility:visible; display:block";
                                                                 }
                                                                else{
                                                                    echo "visibility:hidden; display:none" ;
                                                                    } ?>">
                                <?php foreach ($moisduVisiteur as $moisparVisiteur): ?>
                                <option  value="<?=$moisparVisiteur;?>"><?=$moisparVisiteur; ?></option>
                                <?php endforeach?>
                            </select>
                            <?php endforeach?>
                        </div>                        
                    </div>
                  
                    <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                    role="button">
                </form>
            </div>
        </div>
    </div>
</div>
