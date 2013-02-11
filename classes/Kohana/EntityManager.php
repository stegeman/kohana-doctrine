<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Provide access to a Doctrine2 EntityManager
 *
 * @author René Terstegen (reneterstegen@gmail.com)
 */
class Kohana_EntityManager {
    /**
     * @staticvar EntityManager must be a singleton. This attribute will be set if the EntityManager is created
     */
    private static $instance = null;

    /**
     * Get an instance of the \Doctrine\ORM\EntityManager
     *
     * The EntityManager is build based on the database.php config file
     *
     * @static
     * @access public
     * @return \Doctrine\ORM\EntityManager
     */
    public static function instance() {
        if(is_null(self::$instance)) {
            // Get credentials for connection
            $Config = Doctrine_Config::instance();

            // Get credentials
            $credentials = self::getConnectionCredentials();

            // Create entitymanager
            $entityManager		= \Doctrine\ORM\EntityManager::create($credentials, $Config);

            // Set the entityManager
            self::$instance = $entityManager;
        }
        // Return the entity manager
        return self::$instance;
    }

    /**
     * Get the configuration for the entitymanager
     *
     * @static
     * @access private
     * @return array
     */
    private static function getSettings() {
        return Kohana::$config->load('doctrine');
    }

    /**
     * Get connection credentials to the database
     *
     * @static
     * @access private
     * @uses self::getSettings()
     * @return array
     */
    private static function getConnectionCredentials() {
        return $credentials = self::getSettings()->credentials;
    }
}