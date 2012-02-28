<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Handle the configuration for an Entitymanager
 * 
 * @author René Terstegen (reneterstegen@gmail.com)
 */
class Kohana_Doctrine_Config {
    /**
     * Create a \Doctrine\ORM\Configuration based on the settings given. If no settings are given the method will try to get the 
     * settings from the configuration file.
     * 
     * @static
     * @access public
     * @param array $settings
     * @return \Doctrine\ORM\Configuration
     */
    public static function instance($settings = null) {
        if(is_null($settings)) {
            // Get settings from configuration file
            $settings = self::getSettings();
        }
        
        // Build configuration
        $Config = new \Doctrine\ORM\Configuration();
        
        // Get mapping type
        $Mapping = Doctrine_Mapping::instance($settings->mapping);
        $Config->setMetaDataDriverImpl($Mapping);
        
        // Get cache settings
        $Cache = Doctrine_Cache::instance($settings->cache);
        $Config->setMetadataCacheImpl($Cache);
		$Config->setQueryCacheImpl($Cache);
		
		// Set proxies and proxie-prefix
		$Config->setProxyDir($settings->proxy["path"]);
		$Config->setProxyNamespace($settings->proxy["namespace"]);
		$Config->setAutoGenerateProxyClasses($settings->proxy["generate"]);
        
		// Return result
		return $Config;
    }
    
    /**
     * Get settings from configuration file
     * 
     * @static
     * @access private
     * @return object
     */
    private static function getSettings() {
        return Kohana::$config->load('database');
    }
}