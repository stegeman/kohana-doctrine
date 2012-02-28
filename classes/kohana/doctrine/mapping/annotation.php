<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Generate a Annotation Driver
 * 
 * @author René Terstegen (reneterstegen@gmail.com)
 */
class Kohana_Doctrine_Mapping_Annotation {
    /**
     * Generate an instance of an annotation driver based on the given settings. If no settings are given this method attempts to 
     * retrieve them from the configuration file.
     * 
     * @static
     * @access public
     * @param array $settings
     * @return \Doctrine\ORM\Mapping\Driver\AnnotationDriver 
     */
    public static function instance($settings = null) {
        // Check config
        if(is_null($settings)) {
            $settings = self::getSettings();
        }
        
        // Create annotation driver
        return new \Doctrine\ORM\Mapping\Driver\AnnotationDriver($settings["path"]);
    }
    
    /**
     * Get settings from the config file
     * 
     * @static
     * @access private
     * @return array
     */
    private static function getSettings() {
        return Kohana::$config->load('database')->mapping;    
    } 
}