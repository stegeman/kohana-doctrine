<?php
return array(
    /** Connection settings for the database */
    "credentials"    => array(
                        "driver"        => "pdo_mysql",
                        "path"          => "localhost",
                        "user"          => "root",
                        "password"      => '',
                        "dbname"        => "test",
                        "charset"       => "utf8",
                     ),
    /** Settings for mapping. Only xml is implemented right now */
    "mapping"        => array(
                            "type"          => "xml",
                            //"extension"   => ".dcm.xml", // This is an optional attribute and is set to default
                            "path"          => array(
                                                 realpath(APPPATH.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."xml"),
                                               ),
                        ),
    /** Cache settings. Only arraycache is implemented right now */
    "cache"	         => array(
                         "type"         => "array",
                         // "host"        => "hostname",
                         // "port"        => "11211",
                     ),
    /** Proxy settings */
    "proxy"			 => array(
                         "path"         => realpath(APPPATH.DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR."proxies"),
                         "namespace"    => "Proxies",
                         "generate"     => true,
                     ),
    /** Define namespaces */
    "namespaces"    => array(),
    /** Set production flag */
    "production"    => false,
    /** Set events */
    "events"        => array(
                            "listeners" => array(
                                "class" => array(), // Formated like "ClassnameOfListener" => "arrayWithEvents"
                            ),
                            "subscribers" => array(
                                "class" // EventSubscriberClass
                            ),

    ),
);