<?php
class Membre{
	
    var $sql = null;

    /* CONSTRUCTEUR DE LA CLASSE */
    function __construct() {
            $this->sql = new Site_SQL;
    }
    
    
     /**
     * Creation d'un compte via un provider
     *
     * @access  public
     * @param Object $userData Objet renvoyé par HybridAuth( = les informations du provider) avec les informations de l'utilisateur
     * @param string $provider nom du provider
     * @return int (identifiants de l'utilisateur nouvellement créé)
     */
    public function creationCompteViaProvider($userData, $provider){

        //CREATION DU COMPTE
        if($userData->gender != 'male'){
            $civilite_id = 2;
        }else{
            $civilite_id = 1;
        }

        //GENERATION D'UN MDP ALEATOIRE
        $mdpAleatoire = Cryptage::mdpAleatoire();

        //POUR LES INFORMATIONS DONNEES PAR HYBRID AUTH 
        //http://hybridauth.sourceforge.net/userguide/Profile_Data_User_Profile.html
        $idClientViaProvider = $this->inscription($userData->email, $mdpAleatoire, $userData->lastName, $userData->firstName, $civilite_id, $userData->phone);

        //ASSOCIATION DU COMPTE AU PROVIDER
        $this->associerMembreAProvider($provider, $userData->identifier, $idClientViaProvider);
        return $idClientViaProvider;

    }
    
     /**
     * Associer un contact à un provider
     *
     * @access  public
     * @param string $nomProvider Nom du provider
     * @param string $identifiantProvider Identifiant du client chez le provider
     * @param int $idMembre Identifiant du client chez nous
     * @return bool (Si la manipulation à réussi ou non)
     */
    public function associerMembreAProvider($nomProvider, $identifiantProvider, $idMembre){
        //REQUETE POUR L'ENTREPRISE
        $sqlInsertProvider = "INSERT INTO membre_provider(id, provider, identifiant, membre_id)"
                . " VALUES("
                . " '',"
                . " '".cleanForSql($nomProvider)."',"
                . " '".cleanForSql($identifiantProvider)."',"
                . " '".cleanForSql($idMembre)."'"
                . ")";
        $retour = $this->sql->query($sqlInsertProvider);
        if($retour){
            return true;
        }else{
            return false;
        }
    }

     /**
     * Vérifier si une connexion via provider est déja connue ou non
     *
     * @access  public
     * @param string $provider Nom du provider
     * @param string $identifiant Identifiant du client chez le provider
     * @return int (Si inconnu : 0, sinon, l'identifiant du client chez nous)
     */
    public function providerConnu($provider, $identifiant){
        $sqlGetIdMembreViaProvider = "SELECT membre_id FROM membre_provider WHERE provider = '".cleanForSql($provider)."' AND identifiant = '".cleanForSql($identifiant)."'";
        $this->sql->query($sqlGetIdMembreViaProvider,SQL_INIT,SQL_ASSOC);
        if(isset($this->sql->record['membre_id']) && !empty($this->sql->record['membre_id'])){
            return $this->sql->record['membre_id'];
        }else{
            return 0;
        }
    }

     /**
     * Vérifier si un email est déja utilisé
     *
     * @access  public
     * @param string $email email à tester
     * @return int (Si pas utilisé : 0, sinon, l'identifiant du client)
     */
    public function emailDejaUtilise($email){
        
        $sqlGetMembreDejaExistant = "SELECT id FROM membre WHERE email = '".cleanForSql($email)."'";

        $this->sql->query($sqlGetMembreDejaExistant,SQL_INIT,SQL_ASSOC);
        if(isset($this->sql->record['id']) && !empty($this->sql->record['id'])){
            return $this->sql->record['id'];
        }else{
            return 0;
        }
    }
}