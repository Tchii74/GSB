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

$lesVisiteurs = $pdo->getLesVisiteurs();

 // foreach($lesVisiteurs as $unVisteur)
   // {
     //   $pdo-> creeNouvellesLignesFrais($unVisteur['id'], $moisPrecedent);
    //}

// choix du visiteur et du mois concerné pour la validation des frais
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
case 'selectionnerVisiteur':

    // Afin de sélectionner par défaut le premier visiteur dans la zone de liste
    //on demande le visiteur à l'indice 0 du tableau des visiteurs
    // les visiteurs étant triés par ordre alphabétique
    $visiteurASelectionner = $lesVisiteurs[0]['id'];
    include 'vues/v_listeVisiteurs.php';

  case 'selectionnerMois':
    $lesMois = $pdo->getTousLesMois();
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
