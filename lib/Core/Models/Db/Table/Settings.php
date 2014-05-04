<?php

namespace Core\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Settings extends Table {

    protected $_name = 'settings';
    protected $_primary = 'name';
    protected $_rowClass = "\Core\Models\Db\Row\Setting";
    private $settings = [];

    public function __construct() {
        parent::__construct();
    }

    public function getSetting($name) {
        if (isset($this->settings[$name]))
            return $this->settings[$name];
        $row = $this->fetchRow($this->select()->where("name=?", $name));
        $this->settings[$name] = $row->value;
        return $row->value;
    }

    public function getSettings() {
        return $this->fetchAll();
    }

    public function setSetting($name, $value) {
        $row = $this->fetchRow($this->select()->where("name=?", $name));
        if ($row == NULL)
            throw new \Core\Exception("Try to set undefined setting: \"" . $name . "\"");
        else {
            $row->value = $value;
            return (false !== $row->save());
        }
    }

    public function __get($name) {
        return $this->getSetting($name);
    }

    public function __set($name, $value) {
        return $this->setSetting($name, $value);
    }

}
