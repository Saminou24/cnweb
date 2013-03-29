<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

//define upload path
defined('UPLOAD_PATH')
    || define('UPLOAD_PATH', realpath(dirname(__FILE__).'/photos'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    APPLICATION_PATH. '/models',
    get_include_path(),
)));


//define some parameter
define("BASE_URL", "http://".$_SERVER["SERVER_NAME"]."/");
define("JS_URL", "/../js");
define("CSS_URL", "/../css");
define("IMAGE_URL", "/../images");

/** Zend_Application */
require_once 'Zend/Application.php';
require_once 'Zend/Loader.php';


// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();