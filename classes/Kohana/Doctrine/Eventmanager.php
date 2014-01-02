<?php
/**
 * User:  reneterstegen
 * Email: reneterstegen@gmail.com
 * Date:  02-01-14
 * Time:  13:22
 */

use Doctrine\Common\EventManager;

class Kohana_Doctrine_Eventmanager {

    public static function instance($settings = null) {
        if(is_null($settings)) {
            $settings = self::getSettings();
        }

        $Eventmanager = new EventManager();

        $eventsConfig = $settings['events'];

        foreach($eventsConfig['listeners'] AS $listener => $events) {
            $Eventmanager->addEventListener((array) $events, new $listener());
        }

        foreach($eventsConfig['subscribers'] AS $subscriber) {
            $Eventmanager->addEventSubscriber(new $subscriber());
        }

        return $Eventmanager;
    }

    /**
     * Get settings from configuration file
     *
     * @static
     * @access private
     * @return object
     */
    private static function getSettings() {
        return Kohana::$config->load('doctrine');
    }
} 