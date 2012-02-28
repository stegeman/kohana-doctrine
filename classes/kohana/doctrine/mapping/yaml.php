<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Generate a Doctrine\ORM\Mapping\Driver
 * 
 * @author René Terstegen (reneterstegen@gmail.com)
 */
class Kohana_Doctrine_Mapping_Yaml {
    /**
     * Generate an instance of the Yaml mapping based on the given settings. IF no settings are given, the method tries to retrieve the
     * settings from the config file.
     *
     * @static
     * @access public
     * @param array $config
     * 
     * @return \Doctrine\ORM\Mapping\Driver\YamlDriver
     */
    public static function instance($settings = null) {
        // Check for config
        if(is_null($settings)) {
            $settings = self::getSettings();
        }
        
        // Generate yaml driver
        $yamlDriver = new \Doctrine\ORM\Mapping\Driver\YamlDriver($settings["path"]);

        // Set file extension of yaml files
        if(array_key_exists("extension", $config)) {
            $yamlDriver->setFileExtension($config["extension"]);
        }
        
        return $yamlDriver;
    }
    
    /**
     * Get mapping config from the configuration file
     * 
     * @static
     * @access private
     * @return array 
     */
    private static function getSettings() {
        return Kohana::$config->load('database')->mapping;    
    } 
}