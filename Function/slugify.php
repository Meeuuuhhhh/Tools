<?php

/*
 * REMPLACER UNE CHAINE POUR QU'ELLE DEVIENNE UNE URL VALIDE
 */
function slugify($text){
	
	//ON DECODE
	$text = utf8_decode($text);
	
	//METTRE EN MINUSCULE
	$text = strtolower($text);
	
	//REMPLACER LES ACCENTS
	$text = strtr($text, 'áàâäãåçéèêëíìîïñóòôöõúùûüýÿ', 'aaaaaaceeeeiiiinooooouuuuyy');
	
	//TOUT CE QUI N'EST PAS 'a-z' OU '0-1' OU '-' OU '_', ON REMPLACE PAR UN ESPACE
	$text = preg_replace("#[^0-9a-z-_]#", " ", $text);
	
	//ON TRIM, POUR SUPPRIMER LES ESPACES EN FIN ET DEBUT DE CHAINE
	$text = trim($text);
	
	//ON REMPLACE LES ESPACES PAR DES TIRETS
	$text = str_replace(" ", "-", $text);
	
	//ON SUPPRIME LES DOUBLES TIRETS
	$text = str_replace("--", "-", $text);
	$text = str_replace("--", "-", $text);
	
	return $text;
}

?>
