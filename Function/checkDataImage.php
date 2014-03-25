<?php

/**
 * Vérifie qu'une image :
 *  a la bon type
 *  a la bonne extension
 *  le type et l'extension vont ensemble
 *
 * @access  public
 * @param string $image_file url de l'image a tester
 * @param string $file_name nom de l'image a tester [OPTIONNEL]
 * @param array $type_image_autorises tableau des types que l'on souhaite tester [OPTIONNEL]
 * @return array infos de l'image | tableau vide si les data ne vont pas
 */
function checkDataImage($image_file, $file_name = '', $type_image_autorises = array() ){
    
    if(!isset($image_file) || empty($image_file)){
        return array();
    }
    
    //? A T-ON SPECIFIE DES FORMATS POUR CE TEST ?
    if(empty($type_image_autorises)){
        // => NON
        //ON PREND LES TYPES PAR DEFAUT
        $type_image_autorises = array('gif', 'png', 'jpeg');
    }
    //ON RECUPERE L'EXTENSION DU FICHIER
    // ? A T-ON SPECIFIE UN NOM DE FICHIER ? (FICHIERS TMP)
    if(!empty($file_name)){
        // => OUI
        //ON S'EN SERT POUR L'EXTENSION
        $tabAvecExtension = explode('.', $file_name);
    }else{
        // => NON
        //ON PREND LE CHEMIN DU FICHIER
        $tabAvecExtension = explode('.', $image_file);
    }
    //L'EXTENSION EST LE DERNIER ELEMENT DU TABLEAU
    $Extension = strtolower(array_pop($tabAvecExtension));
    //ON RECUPERE LES INFOS DU FICHIER
    $imageInfo = getimagesize($image_file);
    if(!$imageInfo){
        //ERREUR DE LECTURE
        return array();
    }
    $detectedType = $imageInfo[2];
    //ON MET DANS L'INDEX SIZE, QUI N'EST PAS UTILISE, LA TAILLE DE L'IMAGE
    $imageInfo['size'] = filesize($image_file);
    //SELON LE TYPE
    switch ( $detectedType ) {
        case IMAGETYPE_TIFF_II:
        case IMAGETYPE_TIFF_MM:
            // TIFF
            //? A T-ON AUTORISE LES TIFFS ET L'EXTENSION EST-ELLE BIEN CELLE D'UN TIFF ?
            if (!in_array('tiff', $type_image_autorises) || ('tif' != $Extension && 'tiff' != $Extension) ){
                // => NON
                //LE FORMAT NE CONVIENT PAS
                $formatImageOK = array();
            }else{
                // => OUI
                //LE FORMAT CONVIENT
                $formatImageOK = $imageInfo;
            }
            break;
        case IMAGETYPE_JPEG:
            // JPEG
            //? A T-ON AUTORISE LES JPEGS ET L'EXTENSION EST-ELLE BIEN CELLE D'UN JPEG ?
            if (!in_array('jpeg', $type_image_autorises) || ('jpeg' != $Extension && 'jpg' != $Extension) ){
                // => NON
                //LE FORMAT NE CONVIENT PAS
                $formatImageOK = array();
            }else{
                // => OUI
                //LE FORMAT CONVIENT
                $formatImageOK = $imageInfo;
            }
            break;
        case IMAGETYPE_GIF:
            // GIF
            //? A T-ON AUTORISE LES GIFS ET L'EXTENSION EST-ELLE BIEN CELLE D'UN GIF ?
            if (!in_array('gif', $type_image_autorises) || 'gif' != $Extension  ){
                // => NON
                //LE FORMAT NE CONVIENT PAS
                $formatImageOK = array();
            }else{
                // => OUI
                //LE FORMAT CONVIENT
                $formatImageOK = $imageInfo;
            }
            break;
        case IMAGETYPE_PNG:
            // PNG
            //? A T-ON AUTORISE LES PNGS ET L'EXTENSION EST-ELLE BIEN CELLE D'UN PNG ?
            if (!in_array('png', $type_image_autorises) || 'png' != $Extension  ){
                // => NON
                //LE FORMAT NE CONVIENT PAS
                $formatImageOK = array();
            }else{
                // => OUI
                //LE FORMAT CONVIENT
                $formatImageOK = $imageInfo;
            }
            break;
        case IMAGETYPE_BMP:
            //BMP
            //? A T-ON AUTORISE LES BMPS ET L'EXTENSION EST-ELLE BIEN CELLE D'UN BMP ?
            if (!in_array('bmp', $type_image_autorises) || 'bmp' != $Extension  ){
                // => NON
                //LE FORMAT NE CONVIENT PAS
                $formatImageOK = array();
            }else{
                // => OUI
                //LE FORMAT CONVIENT
                $formatImageOK = $imageInfo;
            }
            break;
        default :
            //ERREUR MAUVAIS TYPE
            $formatImageOK = array();
            break;

    }
    //ON RENVOIT LE RESULTAT
    return $formatImageOK;
}
