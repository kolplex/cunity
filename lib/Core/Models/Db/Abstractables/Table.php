<?php

/*
 * Cunity - Your private social network 
 */

namespace Core\Models\Db\Abstractables;

use Core\Cunity;

/**
 * abstract Table Class which automatically inserts the database-prefix
 *
 * @package    Core
 * @subpackage Abstractables
 * @copyright  Copyright (c) 2013 Smart In Media GmbH & Co. KG (www.smartinmedia.com) 
 */
abstract class Table extends \Zend_Db_Table_Abstract {

    /**
     * Stores the config-object
     *
     * @var Zend_Config_Json
     */
    protected $config;

    /**
     * Stores the Table Prefix as a shortcut variable
     *
     * @var String
     */
    protected $dbprefix;

    /**
     * Overwrite the default Rowset-Class
     *
     * @var String     
     */
    protected $_rowsetClass = "Core\Models\Db\Rowset\Rowset";

    /**
     * _setupTableName     
     */
    protected function _setupTableName() {
        parent::_setupTableName();

        $this->config = Cunity::get("config");
        $this->dbprefix = $this->config->db->params->table_prefix . '_';
        $this->_name = $this->dbprefix . $this->_name;
    }

    public function insert(array $data) {
        if (in_array("time", $this->info(\Zend_Db_Table_Abstract::COLS)))
            $data['time'] = new \Zend_Db_Expr("UTC_TIMESTAMP()");
        return parent::insert($data);
    }

}
