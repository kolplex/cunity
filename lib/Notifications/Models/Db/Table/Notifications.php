<?php

namespace Notifications\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Notifications extends Table {

    protected $_name = 'notifications';
    protected $_primary = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function insertNotification(array $data) {
        return (1 == $this->insert($data));
    }

    public function getNotifications() {
        $result = [];
        $query = $this->getAdapter()->select()->from(["n" => $this->_name])
                ->joinLeft(["u" => $this->dbprefix . "users"], "n.ref_userid=u.userid", ["name", "username"])
                ->joinLeft(["pi" => $this->dbprefix . "gallery_images"], "pi.id = u.profileImage", ['filename AS pimg', 'albumid AS palbumid'])
                ->where("n.userid=?", $_SESSION['user']->userid)
                ->where("unread = 1")
                ->limit(5);
        $res = $this->getAdapter()->fetchAll($query);
        for ($i = 0; $i < count($res); $i++) {
            $d = \Notifications\Models\Notifier::getNotificationData($res[$i]["type"]);
            $res[$i]["message"] = \sprintf($d, $res[$i]["name"]);
            if ($res[$i]["unread"] == 1)
                $result["new"] ++;
        }
        $result["all"] = $res;
        return $result;
    }

    public function read($id) {
        return ($this->update(["unread" => 0], $this->getAdapter()->quoteInto("id=?", $id)) !== false);
    }

}
