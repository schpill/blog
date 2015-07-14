<?php
    namespace Thin;

    set_time_limit(false);

    $ini = parse_ini_file(__DIR__ . '/../../.env');

    defined('FRAMEWORK_DIR')    || define('FRAMEWORK_DIR', isset($ini['FRAMEWORK_DIR']) ? $ini['FRAMEWORK_DIR'] : __DIR__ . '/../../fwk');
    defined('APPLICATION_ENV')  || define('APPLICATION_ENV', isset($ini['APPLICATION_ENV']) ? $ini['APPLICATION_ENV'] : 'production');
    defined('SITE_NAME')        || define('SITE_NAME', isset($ini['SITE_NAME']) ? $ini['SITE_NAME'] : 'project');
    defined('LOCAL_DIR')        || define('LOCAL_DIR', isset($ini['LOCAL_DIR']) ? $ini['LOCAL_DIR'] : '');
    defined('STORAGE_DIR')      || define('STORAGE_DIR', isset($ini['STORAGE_DIR']) ? $ini['STORAGE_DIR'] : __DIR__ . '/../../app/storage');

    require_once FRAMEWORK_DIR . '/public/init.php';
    require_once APPLICATION_PATH . '/Bootstrap.php';
    require_once __DIR__ . DS . '../../vendor/autoload.php';
    require_once __DIR__ . '/../../app/Bootstrap.php';

    Config::set('directory.store', STORAGE_PATH);

    Bootstrap::cli();
    MyApp::cli();
