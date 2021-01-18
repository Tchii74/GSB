<div>
<div class="form-group">
                 <form method="post" 
              action="index.php?uc=validerFrais&action=corrigerNbJustificatifs" 
              role="form">
                <label for="nbJustificatifs">Nombre de justificatifs : </label>
                <input type="text" 
                id="nbJustificatifs" 
                name = "nbJustificatifs"
                size="1" 
                value="<?php echo $nbJustificatifs ?>">
                <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
            <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-danger" 
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
</div>

<div>

<input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
</div>