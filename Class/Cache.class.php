<?php

Class Cache{
    
    private static $cacheDir = '/cache/'; // Dossier de cache
    private static $cacheLifeTime = 1800; // Lifetime du cache
    private static $fileServerTime = 'stime.tmp'; // Fichier pour verifier l'heure serveur
            
    public static function saveCache($fichier, $contenu){
        if(!empty($fichier)){
            $fhandle = fopen(self::$cacheDir.$fichier, 'w+');
            $result = fwrite($fhandle, serialize($contenu));
            fclose($fhandle);
            return true;
        }else{
            return false;
        }
    }

    public static function getCache($fichier){
        if(file_exists (self::$cacheDir.$fichier)){
            $result = file_get_contents(self::$cacheDir.$fichier);
            if($result !== false){
                    return unserialize($result);
            }else{
                    return false;
            }
        }else{
            return false;
        }
    }

    public static function cacheUpToDate($fichier, $lifeTime = ''){
        if(file_exists (self::$cacheDir.$fichier)){
            if(empty($lifeTime)){
                $lifeTime = self::$cacheLifeTime;
            }
            touch(self::$cacheDir.self::$fileServerTime); // Pour éviter un éventuel décalade d'heure dans le serveur
            if(filemtime(self::$cacheDir.self::$fileServerTime) - filemtime(self::$cacheDir.$fichier) < ($lifeTime)){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
}
?>
