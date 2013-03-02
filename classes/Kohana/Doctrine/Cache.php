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
        switch(mb_strtolower($settings["type"])) {
            case 'array':
                return new \Doctrine\Common\Cache\ArrayCache;
                break;
            case 'apc':
                return new \Doctrine\Common\Cache\ApcCache();
                break;
            case 'memcache':
                $memcache = new Memcache();
                $memcache->connect($settings["host"], $settings["port"]);
                $CacheDriver = new \Doctrine\Common\Cache\MemcacheCache();
                $CacheDriver->setMemcache($memcache);
                return $CacheDriver;
                break;
            case 'xcache':
                return new \Doctrine\Common\Cache\XcacheCache();
                break;
            case 'redis':
                if(!class_exists("Redis")) {
                    throw new Exception("Redis cache is not available");
                }
                $redis = new Redis();
                $redis->connect($settings["host"], $settings["port"]);
                $cacheDriver = new \Doctrine\Common\Cache\RedisCache();
                $cacheDriver->setRedis($redis);
                return $cacheDriver;

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
