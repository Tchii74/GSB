<?php
/**
 * Gestion de la validation d'une fiche de frais
 *
 * PHP Version 8
 *
 * @category  PPE
 * @package   GSB
 * @author    Audrey Laval <audreylaval074@gmail.com>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

 // cloture automatique de toutes les fiches de Frais du mois qui vient de s'achever
$mois = getMois(date('d/m/Y'));
$moisPrecedent = new DateTime($mois);
$moisPrecedent -> modify("-1 month");
$moisPrecedent = $moisPrecedent->format('Ym');
$pdo -> ClotToutesFichesFrais($moisPrecedent);


$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {

    //action qui permet le choix du visiteur et du mois 
case 'selectionnerVisiteur':

    // Afin de sélectionner par défaut le premier visiteur dans la zone de liste
    //on demande le visiteur à l'indice 0 du tableau des visiteurs
    // les visiteurs étant triés par ordre alphabétique
    $lesVisiteurs = $pdo->getLesVisiteurs();
    $visiteurASelectionner = $lesVisiteurs[0]['id'];
    $lesMois = $pdo->getLesMoisFicheCloturee();
    $moisASelectionner = $lesMois[0]['mois'];
    $visiteurToutValider = array_diff(array_column($lesVisiteurs,'id'),array_column($lesMois,'idvisiteur'));

    include 'vues/v_listeMoisValiderFiches.php';
    break;

    //action qui affiche le détail de la fiche de frais pour le visiteur et le mois selectionné
case 'voirDetailFrais':

    $lesVisiteurs = $pdo->getLesVisiteurs();
    $lesMois = $pdo->getLesMoisFicheCloturee();
    $visiteurToutValider = array_diff(array_column($lesVisiteurs,'id'),array_column($lesMois,'idvisiteur'));

    $idVisiteurSelectionne = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
    $leMoisSelectionne = filter_input(INPUT_POST, $idVisiteurSelectionne, FILTER_SANITIZE_STRING);

    //include 'vues/v_test.php';

    include 'vues/v_choisirVisiteurValiderFrais.php';
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurSelectionne, $leMoisSelectionne);
    include 'vues/v_listeFraisForfaitComptable.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurSelectionne, $leMoisSelectionne);
    $nbJustificatifs = $pdo->getNbjustificatifs($idVisiteurSelectionne, $leMoisSelectionne);
    include 'vues/v_listeFraisHorsForfaitComptable.php';
    include 'vues/v_validationFicheFrais.php';
    
    break;

    // action modifier les frais forfait
    case 'corrigerMajFraisForfait':
        $idVisiteurSelectionne = filter_input(INPUT_POST, 'idVisiteurSelectionne', FILTER_SANITIZE_STRING);
        $leMoisSelectionne = filter_input(INPUT_POST, 'leMoisSelectionne', FILTER_SANITIZE_STRING);
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        
        if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idVisiteurSelectionne, $leMoisSelectionne, $lesFrais);
            ajouterMessage('Modification des frais forfait prise en compte');
            include 'vues/v_validation.php';
        } else {
            ajouterMessage('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }

        //réaffichage des frais forfait
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $lesMois = $pdo->getTousLesMois();
        $visiteurASelectionner = $idVisiteurSelectionne;
        $moisASelectionner = $leMoisSelectionne;
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurSelectionne, $leMoisSelectionne);
        require 'vues/v_listeFraisForfaitComptable.php';
        
        // réaffichage des frais hors forfait
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurSelectionne, $leMoisSelectionne);
        $nbJustificatifs = $pdo->getNbjustificatifs($idVisiteurSelectionne, $leMoisSelectionne);
        include 'vues/v_listeFraisHorsForfaitComptable.php';
        // réaffichage du bouton de validation de la fiche de frais
        include 'vues/v_validationFicheFrais.php';

    break;
    
        // action modifier les frais hors forfait
    case 'corrigerFraisHorsForfait':
        $idVisiteurSelectionne = filter_input(INPUT_POST, 'idVisiteurSelectionne', FILTER_SANITIZE_STRING);
        $leMoisSelectionne = filter_input(INPUT_POST, 'leMoisSelectionne', FILTER_SANITIZE_STRING);
        $leMoisSuivant = new DateTime($mois);
        $leMoisSuivant -> modify("+1 month");
        $leMoisSuivant = $leMoisSuivant->format('Ym');
        $dateFrais = filter_input(INPUT_POST, 'dateFraisHorsForfait', FILTER_SANITIZE_STRING);
        $libelle = filter_input(INPUT_POST, 'libelleFraisHorsForfait', FILTER_SANITIZE_STRING);
        $montant = filter_input(INPUT_POST, 'montantFraisHorsForfait', FILTER_VALIDATE_FLOAT);

        $idFraisHFaModifier = filter_input(INPUT_POST, 'idFraisHorsForfait', FILTER_SANITIZE_STRING);
      // si bouton refuser
      if (isset($_POST['Refuser'])){
          $pdo -> refuseLigneFrais($idFraisHFaModifier);
        }
      // si bouton reporter 
      elseif (isset($_POST['Reporter'])){
        
        $pdo -> reporteLigneFrais($idFraisHFaModifier);

          if ($pdo->estPremierFraisMois($idVisiteurSelectionne, $leMoisSuivant)) {
             $pdo->creeNouvellesLignesFrais($idVisiteurSelectionne, $leMoisSuivant);
             
             valideInfosFrais($dateFrais, $libelle, $montant);
             if (nbErreurs() != 0) {
                 include 'vues/v_erreurs.php';
                } 
            }
            else {
                 $pdo->creeNouveauFraisHorsForfait(
                     $idVisiteurSelectionne,
                     $leMoisSuivant,
                     $libelle,
                     $dateFrais,
                     $montant,
                    'CR');
                 
                }
            }
            
      //sinon bouton corriger
        else {
         $pdo->majFraisHorsForfait(
            $idFraisHFaModifier,
            $libelle,
            $dateFrais,
            $montant
         );
        }
        //réaffichage des frais forfait

        $lesVisiteurs = $pdo->getLesVisiteurs();
        $lesMois = $pdo->getTousLesMois();
        $visiteurASelectionner = $idVisiteurSelectionne;
        $moisASelectionner = $leMoisSelectionne;

        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurSelectionne, $leMoisSelectionne);
        require 'vues/v_listeFraisForfaitComptable.php';
        
        // réaffichage des frais hors forfait
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurSelectionne, $leMoisSelectionne);
        $nbJustificatifs = $pdo->getNbjustificatifs($idVisiteurSelectionne, $leMoisSelectionne);
        include 'vues/v_listeFraisHorsForfaitComptable.php';

        // réaffichage du bouton de validation de la fiche de frais
        include 'vues/v_validationFicheFrais.php';
    break;


    case 'corrigerNbJustificatifs':
        //réaffichage des frais forfait
        $idVisiteurSelectionne = filter_input(INPUT_POST, 'idVisiteurSelectionne', FILTER_SANITIZE_STRING);
        $leMoisSelectionne = filter_input(INPUT_POST, 'leMoisSelectionne', FILTER_SANITIZE_STRING);
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $lesMois = $pdo->getTousLesMois();
        $visiteurASelectionner = $idVisiteurSelectionne;
        $moisASelectionner = $leMoisSelectionne;

        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurSelectionne, $leMoisSelectionne);
        require 'vues/v_listeFraisForfaitComptable.php';
        
        // réaffichage des frais hors forfait et le nb de justificatifs modifié
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurSelectionne, $leMoisSelectionne);
        
        $nbJustificatifs = filter_input(INPUT_POST, 'nbJustificatifs', FILTER_SANITIZE_STRING);
        $pdo ->majNbJustificatifs($idVisiteurSelectionne, $leMoisSelectionne, $nbJustificatifs);
        include 'vues/v_listeFraisHorsForfaitComptable.php';

        // réaffichage du bouton de validation de la fiche de frais
        include 'vues/v_validationFicheFrais.php';
    break;

    case 'validerFicheFrais':
     $idVisiteurSelectionne = filter_input(INPUT_POST, 'idVisiteurSelectionne', FILTER_SANITIZE_STRING);
     $leMoisSelectionne = filter_input(INPUT_POST, 'leMoisSelectionne', FILTER_SANITIZE_STRING);
     $pdo-> valideLigneFraisHorsForfait($idVisiteurSelectionne,$leMoisSelectionne);
     $pdo -> majEtatFicheFrais($idVisiteurSelectionne,$leMoisSelectionne,'VA');
     $pdo -> majMontantFraisValide($idVisiteurSelectionne,$leMoisSelectionne);
        ajouterMessage('Validation de la fiche de frais effectuée');
        include 'vues/v_validation.php';
        
        break;
}


