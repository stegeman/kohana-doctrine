<?php defined('SYSPATH') or die('No direct script access.');

/**
 * A model to load specific namespaces
 *
 * @author René Terstegen (reneterstegen@gmail.com)
 */
class Kohana_Doctrine_Namespace {
    /**
     * Load all namespaces as defined in the configuration file
     *
     * @static
     * @access public
     * @return void
     */
    public static function initialize() {
        foreach(self::getNamespaces() AS $key => $value) {
            $classLoader = new \Doctrine\Common\ClassLoader($key, $value);
            $classLoader->register();
        }
    }

    /**
     * Get all namespaces from the configuration
     *
     * @static
     * @access private
     * @return array
     */
    private static function getNamespaces() {
        return Kohana::$config->load('doctrine')->namespaces;
    }
}