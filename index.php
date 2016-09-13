<?php

//error_reporting(E_ALL | E_STRICT | E_NOTICE);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_WARNING & ~E_DEPRECATED);

ini_set('display_error',1);

@date_default_timezone_set('Ukraine/Kiev');
//@date_default_timezone_set('Pacific/Midway');

define('XPATH', dirname(__FILE__) );

    
define('X_TEMPLATE', "default" );
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( XPATH.DS.'Sources'.DS.'defines.php' );

xload("class.lib.main");
xload("class.lib.auth");
xload("functions");
xload("mainframe");

//session_start();

$mainframe = new mainframe;

$mainframe->run();


//p( DateTimeZone::listIdentifiers( ) );
?>