<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

return 
	array(
		"base_url" => SITE_URL."libs/hybridauth/", 

		"providers" => array ( 
			// openid providers
			"OpenID" => array (
				"enabled" => false
			),

			"Yahoo" => array ( 
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ),
			),

			"AOL"  => array ( 
				"enabled" => false 
			),

			"Google" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => GOOGLE_APP_ID, "secret" => GOOGLE_APP_SECRET ), 
			),

			"Facebook" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => FACEBOOK_APP_ID, "secret" => FACEBOOK_APP_SECRET_KEY ), 
			),

			"Twitter" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => TWITTER_CONSUMER_KEY_LOGIN, "secret" => TWITTER_CONSUMER_SECRET_LOGIN ) 
			),

			// windows live
			"Live" => array ( 
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),

			"MySpace" => array ( 
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" ) 
			),

			"LinkedIn" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => LINKEDIN_APP_API_KEY, "secret" => LINKEDIN_APP_API_SECRET_KEY ) 
			),

			"Foursquare" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),
		),

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,

		"debug_file" => $_SERVER['DOCUMENT_ROOT']."/libs/hybridauth/logs.log",
	);
