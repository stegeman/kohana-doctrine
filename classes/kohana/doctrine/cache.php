<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Initialize Doctrine Cache to be used by Kohana_Entitymanager
 *
 * @author René Terstegen (reneterstegen@gmail.com)
 */
class Kohana_Doctrine_Cache {

    /**
     * Setup the cache based on the the given settings.
     *
     * If no settings are given the method will attempt to get the information from the config file
     *
     * @TODO: Add other types of caching
     *
     * @static
     * @access public
     * @uses self::getSettings()
     * @param array $settings
     */
    public static function instance($settings = null) {
        if(is_null($settings)) {
            // Get settings from config
            $settings = self::getSettings();
        }

        // Check for type
        switch($settings["type"]) {
            case 'array':
                return new \Doctrine\Common\Cache\ArrayCache;
                break;
        }
    }

    /**
     * Get cache settings from the config file
     *
     * @static
     * @access private
     * @return array
     */
    private static function getSettings() {
        return Kohana::$config->load('doctrine')->cache;
    }
}
