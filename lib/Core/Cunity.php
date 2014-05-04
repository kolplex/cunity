<?php

namespace Core;

use Core\Models\Db\Table\Settings;

class Cunity {

    private static $instance = null;
    private static $instances = [];

    public static function init() {
        self::set("config", new \Zend_Config_Xml("../data/config.xml"));
        self::set("db", new \Zend_Db_Adapter_Mysqli(self::get("config")->db->params));
        \Zend_Db_Table_Abstract::setDefaultAdapter(self::get("db"));
        self::set("settings", new Settings());
        if (function_exists("apache_get_modules")) {
            self::set("mod_rewrite", in_array('mod_rewrite', apache_get_modules()));
        } else
            self::set("mod_rewrite", false);
    }

    public static function get($instance) {
        if (isset(self::$instances[$instance]))
            return self::$instances[$instance];
        else
            throw new \Exception("Instance of \"" . $instance . "\" not found!");
    }

    public static function set($instance, $obj) {
        self::$instances[$instance] = $obj;
    }

}
