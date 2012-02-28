<?php defined('SYSPATH') or die('No direct script access.');

// Define paths to different namespaces of Doctrine
define('DOCTRINEPATH', MODPATH.DIRECTORY_SEPARATOR.'doctrine'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'lib');
define('SYMFONYPATH', DOCTRINEPATH.DIRECTORY_SEPARATOR.'vendor');
define('DOCTRINECOMMON', DOCTRINEPATH.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'doctrine-common'.DIRECTORY_SEPARATOR.'lib');
define('DOCTRINEDBAL', DOCTRINEPATH.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'doctrine-dbal'.DIRECTORY_SEPARATOR.'lib');

// Load the doctrine class loader
require_once(DOCTRINECOMMON.DIRECTORY_SEPARATOR.'Doctrine'.DIRECTORY_SEPARATOR.'Common'.DIRECTORY_SEPARATOR.'ClassLoader.php');

// Load Doctrine\Common
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\Common', DOCTRINECOMMON);
$classLoader->register();

// Load Doctrine\DBAL
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\DBAL', DOCTRINEDBAL.DIRECTORY_SEPARATOR);
$classLoader->register();

// Load Doctrine\ORM
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\ORM', DOCTRINEPATH);
$classLoader->register();

// Load Symfony
$classLoader = new \Doctrine\Common\ClassLoader('Symfony', DOCTRINECOMMON.DIRECTORY_SEPARATOR.'Symfony');
$classLoader->register();

// Load namespaces as defined in configuration
Doctrine_Namespace::initialize();