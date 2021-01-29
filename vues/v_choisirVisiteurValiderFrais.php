<div class="row">
            <form action="index.php?uc=validerFrais&action=voirDetailFrais" 
                method="post" role="form">
                <?php
                $lesMoisParVisiteur=array();
          
                foreach ($lesMois as $unMois)
                {
                    $lesMoisParVisiteur[$unMois['idvisiteur']][$unMois['mois']] = $unMois['mois'];
                }?>    
                    <div class="form-group">
                    <div class="col-md-2">
                    <label for="Visiteur">Choisir le visiteur : </label>
                    </div>
                    <div class="col-md-2">
                        <select id = "lstVisiteur" name="lstVisiteur" class="form-control" onload = "myfunction()" onchange="myfunction()">
                            <?php
                            foreach ($lesVisiteurs as $unVisiteur) {
                            $id = $unVisiteur['id'];
                            $nom = $unVisiteur['nom'];
                            $prenom = $unVisiteur['prenom'];
                                if ($unVisiteur['id'] == $idVisiteurSelectionne) {?>
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
                    <div class = "control-group">
                    <div class="col-md-1">
                    <label for="lstMois">Mois : </label>
                    </div>
                        <?php
                        $tousLesId =array();
                        
                        foreach ($visiteurToutValider as $unIdVisiteur):
                        ?>
                        <p id = "<?= $unIdVisiteur; ?>" 
                            name = "<?= $unIdVisiteur; ?>" 
                            class =" mois" 
                            style = "<?php if ($unIdVisiteur == $visiteurASelectionner)
                                                {
                                                    echo "visibility:visible; display:block";                                                                  
                                                }
                                                else{
                                                    echo "visibility:hidden; display:none" ;
                                                    } ?>"
                            >Pas de fiche de frais à valider pour ce visiteur
                        </p>
                        <?php endforeach;
                        
                        foreach ($lesMoisParVisiteur as $key =>$moisduVisiteur): 
                        $tousLesId[]= "$key";
                        $id = $key;
                        ?>  
                        <div class="col-md-2">                              
                        <select id = "<?= $id; ?>" 
                            name = "<?= $id; ?>" 
                            class ="form-control mois" 
                            style=  "<?php if ($id == $idVisiteurSelectionne)
                                            {
                                                echo "visibility:visible; display:block";
                                            }
                                            else{
                                                    echo "visibility:hidden; display:none" ;
                                                }
                                    ?>">
                            <?php foreach ($moisduVisiteur as $moisparVisiteur):
                                $numAnnee = substr($moisparVisiteur, 0, 4);
                                $numMois = substr($moisparVisiteur, 4, 2);
                            ?>
                            <option  value="<?=$moisparVisiteur;?>"><?= $numMois . '-' . $numAnnee ?></option>
                            <?php endforeach?>
                        </select>
                        </div>
                        <?php endforeach?>
                    </div>                        
                </div>
                <div class="col-md-2">
                <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                role="button">
                </div>
            </form> 
</div> 
        <h2 id="couleurOrange">Valider la fiches de frais</h2>      
