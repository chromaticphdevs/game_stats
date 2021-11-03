<?php

    #################################################
	##             THIRD-PARTY APPS                ##
    #################################################

    define('DEFAULT_REPLY_TO' , 'donotreply@corefounders.com');

    const MAILER_AUTH = [
        'username' => 'donotreply@corefounders.com',
        'password' => '$a%*2wPWJ+B{',
        'host'     => 'corefounders.com',
        'name'     => 'corefounders',
        'replyTo'  => 'donotreply@corefounders.com',
        'replyToName' => 'corefounders'
    ];

    const ITEXMO = [
        'key' => 'ST-MARKA387451_MMZLK',
        'pwd' => '6b9nxyynwt'
    ];

    #################################################
	##             EXTENDED APPS                   ##
	#################################################
	const APP_EXTENSIONS = [
		'cxbook' => [
			'base_controller' => 'Accounts',
			'base_method'     => 'index'
        ]
    ];

    define('APP_EXTENSIONS_PATH' , APPROOT.DS.'softwares');

	#################################################
	##             SYSTEM CONFIG                ##
    #################################################


    define('GLOBALS' , APPROOT.DS.'classes/globals');

    define('SITE_NAME' , 'Corefounders.com');

    define('COMPANY_NAME' , 'CORE FOUNDERS');

    define('KEY_WORDS' , '#############');


    define('DESCRIPTION' , '#############');

    define('AUTHOR' , SITE_NAME);



    /**
     * OTHERS
     */

    define('GAMES_DOTA' , 'dota');
    define('GAMES_ML' , 'mobile_legends');
    define('GAMES_LOL' , 'league_of_legends');
?>