<?php
class Cryptage {
    
    private static $cipher  = MCRYPT_RIJNDAEL_128;    // Algorithme utilisé pour le cryptage des blocs
    private static $key     = CLE_CRYPTAGE;    // Clé de cryptage
    private static $mode    = 'cfb';                        // Mode opératoire
    
    public static function crypt($data, $identifiant){
        $identifiant = strval($identifiant);
        $keyHash = md5(self::$key.strlen($identifiant).$identifiant);
        $key = substr($keyHash, 0,   mcrypt_get_key_size(self::$cipher, self::$mode) );
        $iv  = substr($keyHash, 0, mcrypt_get_block_size(self::$cipher, self::$mode) );
 
        $data = mcrypt_encrypt(self::$cipher, $key, $data, self::$mode, $iv);
        return base64_encode($data);
    }
 
    public static function decrypt($data, $identifiant){
        $identifiant = strval($identifiant);
        $keyHash = md5(self::$key.strlen($identifiant).$identifiant);
        $key = substr($keyHash, 0,   mcrypt_get_key_size(self::$cipher, self::$mode) );
        $iv  = substr($keyHash, 0, mcrypt_get_block_size(self::$cipher, self::$mode) );
 
        $data = base64_decode($data);
        return mcrypt_decrypt(self::$cipher, $key, $data, self::$mode, $iv);
    }
    
    public static function mdpAleatoire($nbCaracteresMdpAleatoires = NB_CARACTERES_MDP_ALEATOIRES){       
        $chaine = 'azertyuiopqsdfghjklmwxcvbn123456789';
        
        $nb_lettres = strlen($chaine) - 1;
        $generation = '';
        for($i=0; $i < $nbCaracteresMdpAleatoires; $i++){
            $pos = mt_rand(0, $nb_lettres);
            $car = $chaine[$pos];
            $generation .= $car;
        }
        return $generation;
    }
    
}
?>