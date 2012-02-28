<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Doctrine_Mapping_XML {
    public static function instance($config = null) {
        if(is_null($config)) {
            $config = self::getSettings();
        }
        
        $xmlDriver = new \Doctrine\ORM\Mapping\Driver\XmlDriver($config["path"]);

        if(array_key_exists("extension", $config)) {
            $xmlDriver->setFileExtension($config["extension"]);
        }
        
        return $xmlDriver;
    }
    
    private static function getSettings() {
        return Kohana::$config->load('database')->mapping;    
    } 
}