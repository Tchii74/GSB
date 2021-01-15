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


// choix du visiteur et du mois concerné pour la validation des frais
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
case 'selectionnerVisiteur':

    // Afin de sélectionner par défaut le premier visiteur dans la zone de liste
    //on demande le visiteur à l'indice 0 du tableau des visiteurs
    // les visiteurs étant triés par ordre alphabétique
    $lesVisiteurs = $pdo->getLesVisiteurs();
    $visiteurASelectionner = $lesVisiteurs[0]['id'];
    $lesMois = $pdo->getTousLesMois();
    $moisASelectionner = $lesMois[0]['mois'];;

    include 'vues/v_listeVisiteurs.php';
    break;

    //affiche le détail de la fiche de frais pour le visiteur et le mois selectionné
case 'voirDetailFrais':
    $idVisiteurSelectionne = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
    $leMoisSelectionne = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);


    // réaffichage du visiteur et du mois selectionné
    $lesVisiteurs = $pdo->getLesVisiteurs();
    $lesMois = $pdo->getTousLesMois();
    $visiteurASelectionner = $idVisiteurSelectionne;
    $moisASelectionner = $leMoisSelectionne;
    include 'vues/v_listeVisiteurs.php';

    // affichage des détails de la fiche de frais demandée
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurSelectionne, $leMoisSelectionne);
    include 'vues/v_listeFraisForfaitComptable.php';

    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurSelectionne, $leMoisSelectionne);
    $nbJustificatifs = $pdo->getNbjustificatifs($idVisiteurSelectionne, $leMoisSelectionne);
    include 'vues/v_listeFraisHorsForfaitComptable.php';
    break;


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

        // réaffichage du visiteur et du mois selectionné
    $lesVisiteurs = $pdo->getLesVisiteurs();
    $lesMois = $pdo->getTousLesMois();
    $visiteurASelectionner = $idVisiteurSelectionne;
    $moisASelectionner = $leMoisSelectionne;
        include 'vues/v_listeVisiteurs.php';

        //réaffichage des frais forfait
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurSelectionne, $leMoisSelectionne);
        require 'vues/v_listeFraisForfaitComptable.php';
        
        // réaffichage des frais hors forfait
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurSelectionne, $leMoisSelectionne);
    $nbJustificatifs = $pdo->getNbjustificatifs($idVisiteurSelectionne, $leMoisSelectionne);
    include 'vues/v_listeFraisHorsForfaitComptable.php';
break;

}


