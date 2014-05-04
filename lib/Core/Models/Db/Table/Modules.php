<?php

namespace Core\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Modules extends Table {

    protected $_name = 'modules';
    protected $_primary = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function getModules() {
        return $this->fetchAll();
    }

    public function getModuleData($moduletag) {
        return $this->fetchRow($this->select()->where("namespace=?",$moduletag)->limit(1));
    }

}
