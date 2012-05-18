<?php
//$classLoader = new \Doctrine\Common\ClassLoader('Entity', ENTITY_PATH);
//$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader("Acl", MODPATH.DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."models");
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('proxies', PROXY_PATH);
$classLoader->register();

$config = new \Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$config->setProxyDir(PROXY_PATH . '/proxies');
$config->setProxyNamespace('Proxies');

$driverImpl = new \Doctrine\ORM\Mapping\Driver\XmlDriver(ENTITY_PATH.DIRECTORY_SEPARATOR.'xml');
$config->setMetadataDriverImpl($driverImpl);

$connectionOptions =  array(
	"driver"		    => "pdo_mysql",
	"path"			    => "localhost",
	"user"			    => "root",
	"password"		    => '',
	"dbname"		    => "base",
    "generateproxies"   => false,
);

$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));
