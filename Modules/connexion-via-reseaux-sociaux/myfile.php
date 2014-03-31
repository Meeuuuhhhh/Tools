<?php

 /**
  * Fichier pour faire fonctionner HybridAuth
  *
  * Fichier qui s'occupe de la connexio via HybridAuth
  * A modifier selon les besoins
  *
  * @author tollivier <t.ollivier@atgroupe.fr>
  * @version 1.0
  */

//POUR FAIRE FONCTIONNER :
// CONFIGURER LE FICHIER DE CONFIG (SITE_DIR.'libs/hybridauth/config.php')
require(SITE_DIR . 'libs/hybridauth/Hybrid/Auth.php'); //INCLURE LA LIBRAIRIE DANS LE SETUP (CA PEUT AIDER)
$configHybridAuth = SITE_DIR.'libs/hybridauth/config.php'; //RECUPERATION DE LA CONFIG HYBRID AUTH
$hybridauth = new Hybrid_Auth( $configHybridAuth ); //DEFINIR UN OBJET

#######################################################
#	      hybrid auth                             #
#######################################################
#
//POUR SE CONNECTER VIA UN PROVIDER : 
//ARRIVER SUR UNE PAGE AVEC EN PARAMETRE GET LE NOM DU PROVIDER (monurl.php?provider=Facebook)
if( isset( $_GET["provider"] ) && $_GET["provider"] ):
    try{
        //RECUPERER LE NOM DU PROVIDER
        $provider = @ trim( strip_tags( $_GET["provider"] ) );

        //ON TENTE DE LANCER LA CONNEXION
        $adapter = $hybridauth->authenticate( $provider );          

        //RECUPERER LES INFOS RENVOYEES PAR LE PROVIDER
        $user_data = $adapter->getUserProfile();

        //IL Y A DEUX COMPORTEMENTS A PRENDR EN COMPTE :
        // 1. LE USER A DEJA UN COMPTE AVEC L'EMAIL DU PROVIDER
        // => ON LE CONNECTE A SON COMPTE, MAIS ON ENREGISTRE L'ID RENVOYE PAR LE PROVIDER
        // 2. LE USER NE S'EST CONNECTE(OU INSCRIT) AVEC CET EMAIL
        // => ON LUI CREE UN COMPTE, PUIS ON ASSOCIE LE PROVIDER SI ON L'A PAS DEJA FAIT

        $idMembre = $classMembre->emailDejaUtilise($user_data->email);
        //ON LE CONNAIT ?
        if(!$idMembre){
            //ON LUI CREE UN COMPTE
            $idMembre = $classMembre->creationCompteViaProvider($user_data, $provider);
        }else{
            //ON LE CONNAIT :
            //CE PROVIDER EST DEJA CHEZ NOUS ?
            $idViaProvider = $classMembre->providerConnu($provider, $user_data->identifier);
            if($idViaProvider){
                //OUI
                //ON EST BONS
            }else{
                //NON : ON L'AJOUT
                $classMembre->associerContactAProvider($provider, $user_data->identifier, $idMembre);
            }
        }

        //IL EST CONNECTE !
        $classMembre->connexionSansMdp($idMembre);

        //ON EST TOUT BON : ON REDIRIGE APRES CONNEXION SUR LA PAGE :
        $hybridauth->redirect( "home.html" );
    } catch( Exception $e ){
        // In case we have errors 6 or 7, then we have to use Hybrid_Provider_Adapter::logout() to 
        // let hybridauth forget all about the user so we can try to authenticate again.

        // Display the recived error, 
        // to know more please refer to Exceptions handling section on the userguide
        switch( $e->getCode() ){ 
            case 0 : $error = "Unspecified error."; break;
            case 1 : $error = "Hybriauth configuration error."; break;
            case 2 : $error = "Provider not properly configured."; break;
            case 3 : $error = "Unknown or disabled provider."; break;
            case 4 : $error = "Missing provider application credentials."; break;
            case 5 : $error = "Authentication failed. The user has canceled the authentication or the provider refused the connection."; break;
            case 6 : $error = "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again."; 
                $adapter->logout(); 
                break;
            case 7 : $error = "User not connected to the provider."; 
                $adapter->logout(); 
                break;
        } 

        if(ENVIRONNEMENT != 'PROD'){
            //POUR LE DBUT
            $error .= "<br /><br /><b>Original error message:</b> " . $e->getMessage(); 
            $error .= "<hr /><pre>Trace:<br />" . $e->getTraceAsString() . "</pre>";
            print_r($error);
        }
        //GESTION DU CAS D'ERREUR : PETIT MESSAGE QUI VA BIEN POUR LE VISITEUR
    }
endif;
