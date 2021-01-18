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
