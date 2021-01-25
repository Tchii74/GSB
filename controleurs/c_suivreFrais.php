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


$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {

    case 'choisirFiche':

        // Afin de sélectionner par défaut le premier visiteur dans la zone de liste
    //on demande le visiteur à l'indice 0 du tableau des visiteurs
    // les visiteurs étant triés par ordre alphabétique
    $lesVisiteurs = $pdo->getLesVisiteurs();
    $visiteurASelectionner = $lesVisiteurs[0]['id'];
    
    $lesMois = $pdo->getTousLesMois();
   include 'vues/v_listeMoisSuivrePaiement.php';

    break;

    //action qui affiche le détail de la fiche de frais pour le visiteur et le mois selectionné
case 'voirFrais':
    $idVisiteurSelectionne = filter_input(INPUT_POST, 'Visiteur', FILTER_SANITIZE_STRING);
    $leMoisSelectionne = filter_input(INPUT_POST, $idVisiteurSelectionne , FILTER_SANITIZE_STRING);

    // vérifie si la fiche validée existe pour le visiteur et le mois séléctionné
    if (!$pdo->ficheValideExiste($idVisiteurSelectionne,$leMoisSelectionne)){
        ajouterMessage('Pas de fiche de Frais validée pour ce visiteur ce mois');
        include 'vues/v_erreurs.php';
        // réaffichage du visiteur et du mois selectionné
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $visiteurASelectionner = $lesVisiteurs[0]['id'];
        
        $lesMois = $pdo->getTousLesMois();
       include 'vues/v_listeMoisSuivrePaiement.php';

    } else {

        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurSelectionne, $leMoisSelectionne);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurSelectionne, $leMoisSelectionne);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteurSelectionne, $leMoisSelectionne);
        $numAnnee = substr($leMoisSelectionne, 0, 4);
        $numMois = substr($leMoisSelectionne, 4, 2);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $montantValide = $lesInfosFicheFrais['montantValide'];
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
        include 'vues/v_etatFrais.php';
        //affichage des bouttons de modification de l'état de la fiche de frais
        $idEtat = $pdo ->getEtatFiche($idVisiteurSelectionne, $leMoisSelectionne);
        if ($idEtat == 'VA')
        {
            include 'vues/v_mettreEnPaiement.php';
        }
        elseif ($idEtat=='MP')
        {
            include 'vues/v_rembourserFrais.php';
        }
        else
        {
            //plus de modifications à effectuer
        }
    }    

    break;

    case 'mettreEnPaiement':
        //modification de l'état de la fiche de frais
        $idVisiteurSelectionne = filter_input(INPUT_POST, 'idVisiteurSelectionne', FILTER_SANITIZE_STRING);
        $leMoisSelectionne = filter_input(INPUT_POST, 'leMoisSelectionne' , FILTER_SANITIZE_STRING);
        $pdo -> majEtatFicheFrais($idVisiteurSelectionne,$leMoisSelectionne,'MP');

        // réaffichage des infos de la fiches
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurSelectionne, $leMoisSelectionne);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurSelectionne, $leMoisSelectionne);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteurSelectionne, $leMoisSelectionne);
        $numAnnee = substr($leMoisSelectionne, 0, 4);
        $numMois = substr($leMoisSelectionne, 4, 2);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $montantValide = $lesInfosFicheFrais['montantValide'];
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
        include 'vues/v_etatFrais.php';
        include 'vues/v_rembourserFrais.php';

        break;

    case 'confirmerRemboursement':
        //modification de l'état de la fiche de frais
        $idVisiteurSelectionne = filter_input(INPUT_POST, 'idVisiteurSelectionne', FILTER_SANITIZE_STRING);
        $leMoisSelectionne = filter_input(INPUT_POST, 'leMoisSelectionne' , FILTER_SANITIZE_STRING);
        $pdo -> majEtatFicheFrais($idVisiteurSelectionne,$leMoisSelectionne,'RB');

         // réaffichage des infos de la fiches
         $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurSelectionne, $leMoisSelectionne);
         $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurSelectionne, $leMoisSelectionne);
         $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteurSelectionne, $leMoisSelectionne);
         $numAnnee = substr($leMoisSelectionne, 0, 4);
         $numMois = substr($leMoisSelectionne, 4, 2);
         $libEtat = $lesInfosFicheFrais['libEtat'];
         $montantValide = $lesInfosFicheFrais['montantValide'];
         $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
         $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
         include 'vues/v_etatFrais.php';

        break;
}