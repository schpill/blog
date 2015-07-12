<?php
    /**
    * Thin is a swift Framework for PHP 5.4+
    *
    * @package    Thin
    * @version    1.0
    * @author     Gerald Plusquellec
    * @license    BSD License
    * @copyright  1996 - 2015 Gerald Plusquellec
    * @link       http://github.com/schpill/thin
    */

    namespace Thin;

    $ini = parse_ini_file(__DIR__ . '/../.env');

    defined('FRAMEWORK_DIR')    || define('FRAMEWORK_DIR', isset($ini['FRAMEWORK_DIR']) ? $ini['FRAMEWORK_DIR'] : __DIR__ . DIRECTORY_SEPARATOR . '../fwk');
    defined('APPLICATION_ENV')  || define('APPLICATION_ENV', isset($ini['APPLICATION_ENV']) ? $ini['APPLICATION_ENV'] : 'production');
    defined('SITE_NAME')        || define('SITE_NAME', isset($ini['SITE_NAME']) ? $ini['SITE_NAME'] : 'project');
    defined('LOCAL_DIR')        || define('LOCAL_DIR', isset($ini['LOCAL_DIR']) ? $ini['LOCAL_DIR'] : '');
    defined('STORAGE_DIR')      || define('STORAGE_DIR', isset($ini['STORAGE_DIR']) ? $ini['STORAGE_DIR'] : __DIR__ . '/../app/storage');

    require_once FRAMEWORK_DIR . DIRECTORY_SEPARATOR . 'public/init.php';
    require_once APPLICATION_PATH . DS . 'Bootstrap.php';
    require_once __DIR__ . DS . '../app' . DS . 'Bootstrap.php';

    Timer::start();

    Bootstrap::cli(true);

    if (!session_id()) {
        session_start();
    }

    MyApp::run();
