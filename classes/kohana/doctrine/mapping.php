<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Set mapping type
 * 
 * @TODO: Implement other mappingtypes
 * @author René Terstegen (reneterstegen@gmail.com)
 */
class Kohana_Doctrine_Mapping {
    
    /**
     * Build a Doctrine_Mapping based on the settings provided. If no settings provided the method will try to get the settings 
     * from the configuration file.
     * 
     * @static
     * @access public
     * @param array $settings
     * @uses self::getSettings()
     * 
     * @return \Docrine_Mapping_*
     */
    public static function instance($settings = null) {
        if(is_null($settings)) {
            $settings = self::getSettings();
        }
        
        return Doctrine_Mapping_Xml::instance($settings);
    }
    
    /**
     * Get mapping settings from configuration file
     * 
     * @static
     * @access private
     * @return array
     */
    private static function getSettings() {
        return Kohana::$config->load('database')->mapping;
    }
}
