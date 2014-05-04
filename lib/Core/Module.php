<?php

namespace Core;

class Module {

    protected $_tag;
    private $_data;

    public function __construct($moduletag) {
        $this->_tag = $moduletag;
        if (!class_exists($this->getClassName()))
            throw new Exception("Module \"" . $moduletag . "\" not found!");
        else {
            $modules = new \Core\Models\Db\Table\Modules();
            $this->_data = $modules->getModuleData($this->_tag);
        }
    }

    public function isValid() {
        return (class_exists($this->getClassName()) &&
                in_array('Core\ModuleController', class_implements($this->getClassName())));
    }

    public function getClassName() {
        return ucfirst($this->_tag) . "\Controller";
    }

    public function isActive() {
        if ($this->_data !== NULL)
            return $this->_data['status'];
        else
            return true;
    }

}
