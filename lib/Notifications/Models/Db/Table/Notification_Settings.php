<?php

namespace Notifications\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Notification_Settings extends Table {

    protected $_name = 'notification_settings';

    public function __construct() {
        parent::__construct();
    }

    public function getSetting($name, $userid) {
        $res = $this->fetchRow($this->select()->from($this, "value")->where("userid=?", $userid)->where("name=?", $name));
        if ($res == NULL || $res == false)
            return 3;
        return $res->value;
    }

    public function updateSettings(array $values) {
        $res = [];
        $res[] = (0 < $this->delete($this->getAdapter()->quoteInto("userid=?", $_SESSION['user']->userid)));
        foreach ($values AS $name => $value)
            $res[] = $this->insert(["userid" => $_SESSION['user']->userid, "name" => $name, "value" => $value]);
        return !in_array(false, $res);
    }

}
