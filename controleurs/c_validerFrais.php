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

// choisir le visiteur et le mois concerné


$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
case 'selectionnerVisiteur':
    $lesVisiteurs = $pdo->getLesVisiteurs();

    // Afin de sélectionner par défaut le premier visiteur dans la zone de liste
    // on demande toutes les clés, et on prend la première,
    // les visiteurs étant triés par ordre alphabétique
    $visiteurASelectionner = $lesVisiteurs[0]['id'];
    include 'vues/v_listeVisiteurs.php';

  
case 'selectionnerMois':
    $lesMois = $pdo->getLesMoisDisponibles($visiteurASelectionner);
   include 'vues/v_ListeMoisVisiteur.php';
   
    break;
case 'voirEtatFrais':
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
    $moisASelectionner = $leMois;
    include 'vues/v_listeMois.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_etatFrais.php';
}
