<?php //defined('SYSPATH') or die('No direct script access.');

// Define paths to different namespaces of Doctrine
//define('DOCTRINEPATH', MODPATH.DIRECTORY_SEPARATOR.'doctrine'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'lib');
//define('SYMFONYPATH', DOCTRINEPATH.DIRECTORY_SEPARATOR.'vendor');
//define('DOCTRINECOMMON', DOCTRINEPATH.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'doctrine-common'.DIRECTORY_SEPARATOR.'lib');
//define('DOCTRINEDBAL', DOCTRINEPATH.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'doctrine-dbal'.DIRECTORY_SEPARATOR.'lib');

$pathToDoctrine = __DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR;

// Load the doctrine class loader
require $pathToDoctrine.'lib'.DIRECTORY_SEPARATOR.'Doctrine/ORM/Tools/Setup.php';

// Load doctrine paths
Doctrine\ORM\Tools\Setup::registerAutoloadGit($pathToDoctrine);

// Load namespaces as defined in configuration
Doctrine_Namespace::initialize();

Route::set("doctrine/demo", "doctrine/demo")
     ->defaults(
         array(
             'controller'    => 'Doctrine',
             'action'        => 'demo'
         )
     );