<?php

/*
 * FICHIER D'EXEMPLE DE L'UTILISATION DES DROITS 
 */

//POUR FAIRE FONCTIONNER :
require(SITE_DIR . 'libs/droit.lib.php'); // INCLURE LA LIBRAIRIE DANS LE SETUP (CA PEUT AIDER)
$classDroit = New Droit(); // DEFINIR UN OBJET

// ON VEUT RECUPERER LES DROITS D'UNE OFFRE DANS LE GROUPE PRODUIT, LA VALEUR DU NOMBRE DE PRODUITS SIMULTANES AFFICHES,
$nbMaxProduitsVisibles = $classDroit->getValeurDroit('produits', 'affiche_nb_max', $IdOffreEntrepriseEnCours);

//SI L'ACTION N'EST PAS EN BDD 
    //ET QUE LA LIGNE
    define('DROITS_ACTIONS_PEUPLAGE_AUTOMATIQUE', true); // Savoir si la table des actions doit se peupler toute seule
    //EST DEFINIE A TRUE
        //ALORS, L'ACTION SERA INSEREE EN BASE

    //SINON SI LA LIGNE N'EST PAS DEFINIE OU 
    define('DROITS_ACTIONS_PEUPLAGE_AUTOMATIQUE', false); // Savoir si la table des actions doit se peupler toute seule
    //EST DEFINIE A FALSE
        //ALORS, LA FONCTION RENVERRA UNE ERREUR (false)
