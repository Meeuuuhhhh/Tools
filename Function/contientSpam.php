<?php

function contientSpam($valeurs){
    $spam = '';
    if(is_array($valeurs)){
        foreach($valeurs as $clef=>$champ){
            $spam .= contientSpam($champ);
        }
    }else{
        if(stripos($valeurs, '[url=') !== false){
            $spam = 'spam';
        }
    }
    return $spam;
}
