<?php
/*
 * CLASSE POUR LA GESTION DES DIFFERENTS DROITS
 */
class Droit{
	
	var $sql = null; // variable qui contient la connexion a sql de la classe
	
	/* CONSTRUCTEUR DE LA CLASSE */
	function __construct() {
            
            //INITIALISAITON DE LA CONNEXION SQL
            $this->sql = new Site_SQL;
            
	}
        
        /**
         * Recupère les droits d'une offre pour une action
         *
         * @access  public
         * @param string $nomGroupe nom du groupe dans lequel l'action est
         * @param string $nomAction nom de l'action recherchée
         * @param string $idOffre id de l'offre pour laquelle on veut les droits
         * @return mixed (valeur du droit | false si pas de résultat) {Attention aux droits valant 0, penser à tester === false}
         */
        public function getValeurDroit($nomGroupe, $nomAction, $idOffre){
            
            //LA REQUETE POUR RECUPERER LES INFOS
            $sqlRecupInfosAction = "SELECT * FROM action WHERE groupe = '".cleanForSql($nomGroupe)."' AND nom = '".cleanForSql($nomAction)."'";
            //ON LANCE LA REQUETE
            $this->sql->query($sqlRecupInfosAction,SQL_INIT,SQL_ASSOC);
            $action = $this->sql->record;
            //UN RESULTAT ?
            if(empty($action)){
                // => NON
                //PEUPLAGE AUTOMATIQUE ?
                if(defined('DROITS_ACTIONS_PEUPLAGE_AUTOMATIQUE') && DROITS_ACTIONS_PEUPLAGE_AUTOMATIQUE){
                    // => OUI
                    //REQUETE POUR INSERER EN BASE
                    $sqlInsertAction = "INSERT INTO action(groupe,nom)"
                            . " VALUES('".$nomGroupe."','".$nomAction."')";
                    //ON LANCE LA REQUETE
                    $this->sql->query($sqlInsertAction);
                    $action = array(
                        'id' => mysql_insert_id(),
                        'groupe' => $nomGroupe,
                        'description' => '',
                        'nom' => $nomAction
                    );
                }else{
                    // => NON
                    // ON RENVOIT UN ERRUER
                    return false;
                }
            }
            //$action CONTIENT L'ENREGISTREMENT EN COURS
            
            //ON RECUPERE LA VALEUR DE L'ACTION POUR L'OFFRE DEMANDEE
            $sqlRecupValAction = "SELECT * FROM offre_action_valeur oav"
                    . " LEFT JOIN action a ON oav.action_id = a.id "
                    . " WHERE oav.offre_id = '".cleanForSql($idOffre)."' AND oav.action_id = '".cleanForSql($action['id'])."'";
            $this->sql->query($sqlRecupValAction, SQL_INIT, SQL_ASSOC);
            // A-T-ON UN RESULTAT ?
            if(empty($this->sql->record)){
                // => NON
                return false;
            }
            //ON RENVOIT L'ACTION
            return $this->sql->record['valeur'];
            
        }
        
        public function majDroits($parameters){
            
            ######################################################################################################
            # ON MET A JOUR LES DROITS : CERTAINES MODIFICATIONS DOIVENT PROBABLEMENT ETRE APPORTEES SELON LE SITE
            ######################################################################################################
            return false;
            
        }

}
?>
