<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
 */
try {
    // Specify paths of Doctrine namespaces and application path of Kohana
    define("DOCTRINE_ORM", realpath(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."lib"));
    define("DOCTRINE_DBAL", DOCTRINE_ORM.DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."doctrine-dbal".DIRECTORY_SEPARATOR."lib");
    define("DOCTRINE_COMMON", realpath(DOCTRINE_ORM.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'doctrine-common'.DIRECTORY_SEPARATOR.'lib'));
    define("SYMFONY", realpath(DOCTRINE_ORM.DIRECTORY_SEPARATOR."vendor"));
    define("APPPATH", realpath(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."application".DIRECTORY_SEPARATOR));
    define("MODPATH", realpath(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR));

    // Load Doctrine namespaces
    require_once realpath(DOCTRINE_COMMON.DIRECTORY_SEPARATOR.'Doctrine/Common/ClassLoader.php');

    $classLoader = new \Doctrine\Common\ClassLoader('Doctrine\ORM', DOCTRINE_ORM);
    $classLoader->register();

    $classLoader = new \Doctrine\Common\ClassLoader('Doctrine\DBAL', DOCTRINE_DBAL);
    $classLoader->register();

    $classLoader = new \Doctrine\Common\ClassLoader('Doctrine\Common', DOCTRINE_COMMON);
    $classLoader->register();

    $classLoader = new \Doctrine\Common\ClassLoader('Symfony', SYMFONY);
    $classLoader->register();

    // Load configuration file
    $configFile = APPPATH.DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."doctrine.php";
    if(!file_exists($configFile)) {
        throw new Exception ("Could not find configuration file. Configuration file expected at '$configFile'");
    }

    if(!is_readable($configFile))
        throw new Exception ("Could not read configuration file. Please change permission on config file '$configFile'");

    // Load the config file in a variable
    $config = require_once($configFile);

    /** Load all namespaces specified in configuration */
    foreach($config["namespaces"] AS $namespace => $path) {
        $classLoader = new \Doctrine\Common\ClassLoader($namespace, $path);
        $classLoader->register();
    }

    /** Load mapping as specified in configuration */
    $Configuration = new \Doctrine\ORM\Configuration();
    switch($config["mapping"]["type"]) {
        case "annotation":
            $mapping = $Configuration->newDefaultAnnotationDriver($config["mapping"]["path"]);
            break;
        case "xml":
            $mapping = new \Doctrine\ORM\Mapping\Driver\XmlDriver($config["mapping"]["path"]);

            // Set file extension of XML files
            if(array_key_exists("extension", $config["mapping"]))
                $mapping->setFileExtension($config["mapping"]["extension"]);
            break;
        case "yaml":
            // Generate yaml driver
            $mapping = new \Doctrine\ORM\Mapping\Driver\YamlDriver($config["mapping"]["path"]);

            // Set file extension of yaml files
            if(array_key_exists("extension", $config["mapping"])) {
                $mapping->setFileExtension($config["mapping"]["extension"]);
            }
            break;
    }

    /** Load caching as specified in configuration */
    switch($config["cache"]["type"]) {
        case "array":
            $Cache = new \Doctrine\Common\Cache\ArrayCache;
            break;
        case 'apc':
            $Cache =  new \Doctrine\Common\Cache\ApcCache();
            break;
        case 'memcache':
            $memcache = new Memcache();
            $memcache->connect($settings["host"], $settings["port"]);
            $Cache = new \Doctrine\Common\Cache\MemcacheCache();
            $Cache->setMemcache($memcache);
            break;
        case 'xcache':
            $Cache = \Doctrine\Common\Cache\XcacheCache();
            break;
        case 'redis':
            if(!class_exists("Redis")) {
                throw new Exception("Redis cache is not available");
            }
            $redis = new Redis();
            $redis->connect($settings["host"], $settings["port"]);
            $Cache = new \Doctrine\Common\Cache\RedisCache();
            $Cache->setRedis($redis);
    }

    // Build configuration
    $Configuration->setMetadataCacheImpl($Cache);
    $Configuration->setProxyDir($config["proxy"]["path"]);
    $Configuration->setProxyNamespace($config["proxy"]["namespace"]);
    $Configuration->setMetadataDriverImpl($mapping);

    // Create EntityManager
    $em = \Doctrine\ORM\EntityManager::create($config["credentials"], $Configuration);

    // Set all helpers
    $helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
        'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
        'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
    ));

    $helperSet = ($helperSet) ?: new \Symfony\Component\Console\Helper\HelperSet();

    // Run console
    \Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);
} catch(Exception $e) {
    echo $e->getMessage();
}