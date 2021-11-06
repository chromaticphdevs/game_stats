<?php
    define('SYSTEM_MODE' , $system['mode']);

    define('UI_THEME' , $ui['vendor']);

    define('APP_NAME' , $system['app_name']);


    define('DB_PREFIX' , 'hr_');

    switch(SYSTEM_MODE)
    {
        case 'local':
            define('URL' , 'http://th.game_stats');
            define('DBVENDOR' , 'mysql');
            define('DBHOST' , 'localhost');
            define('DBUSER' , 'root');
            define('DBPASS' , '');
            define('DBNAME' , 'game_stats');

            define('BASECONTROLLER' , 'HomeController');
            define('BASEMETHOD' , 'index');

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        break;

        case 'dev':
            define('URL' , '');
            define('DBVENDOR' , '');
            define('DBHOST' , '');
            define('DBUSER' , '');
            define('DBPASS' , '');
            define('DBNAME' , '');

            define('BASECONTROLLER' , 'Pages');
            define('BASEMETHOD' , 'index');

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        break;

        case 'down':
            define('URL' , '');
            define('DBVENDOR' , '');
            define('DBHOST' , '');
            define('DBUSER' , '');
            define('DBPASS' , '');
            define('DBNAME' , '');

            define('BASECONTROLLER' , 'Maintenance');
            define('BASEMETHOD' , 'index');

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        break;

        case 'up':
            define('URL' , '#');
            define('DBVENDOR' , '#');
            define('DBHOST' , '#');
            define('DBUSER' , '#');
            define('DBPASS' , '#');
            define('DBNAME' , '#');

            define('BASECONTROLLER' , '#');
            define('BASEMETHOD' , '#');
            
        break;
    }