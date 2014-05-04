<?php

namespace Friends\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Relationships extends Table {

    protected $_name = 'relations';
    protected $_primary = 'relation_id';
    protected $_rowClass = "\Friends\Models\Db\Row\Relation";

    public function __construct() {
        parent::__construct();
    }

    public function getRelation($user, $secondUser) {
        return $this->fetchRow($this->select()->where("sender=$user AND receiver = $secondUser")->orWhere("sender=$secondUser AND receiver = $user"));
    }

    public function deleteRelation($user, $secondUser) {
        return $this->getRelation($user, $secondUser)->delete();
    }

    public function updateRelation($user, $secondUser, array $updates) {
        return $this->getRelation($user, $secondUser)->setFromArray($updates)->save();
    }

    public function getFriendList($status = ">1", $userid = 0) {
        if ($userid == 0)
            $userid = $_SESSION['user']->userid;
        else
            $userid = intval($userid);
        if (!is_string($status) && $status == 0) // Only user, who blocked another people is allowed to get this list
            $query = $this->getAdapter()->query("SELECT receiver AS friend FROM " . $this->dbprefix . "relations WHERE " . $this->getAdapter()->quoteInto("sender=?", $userid) . " AND status = 0");
        else
            $query = $this->getAdapter()->select()
                    ->from($this->dbprefix . "relations", new \Zend_Db_Expr("(CASE WHEN sender = " . $userid . " THEN receiver WHEN receiver = " . $userid . " THEN sender END) AS friend"))
                    ->where("status ".$status)
                    ->where("sender=? OR receiver = ? ", $userid);
        $res = $this->getAdapter()->fetchAll($query);        
        $result = [];
        foreach ($res AS $friend)
            $result[] = $friend['friend'];
        return $result;
    }

    public function getFullFriendList($status = ">1", $userid = 0) {
        $friends = $this->getFriendList($status, $userid);        
        if (!empty($friends)) {
            $users = $_SESSION['user']->getTable();
            return $users->getSet($friends, "u.userid", ["u.userid", "u.username", "u.name"],true)->toArray();
        }return null;
    }

    public function getFriendRequests($userid = 0) {
        if ($userid == 0)
            $userid = $_SESSION['user']->userid;
        $res = $this->fetchAll($this->select()->from($this, ["sender"])->where("receiver=?", $userid)->where("status=1"));
        $result = [];
        foreach ($res AS $friend)
            $result[] = $friend['sender'];
        return $result;
    }

    public function getFullFriendRequests($userid = 0) {
        $friends = $this->getFriendRequests($userid);
        if (!empty($friends)) {
            $users = new \Core\Models\Db\Table\Users();
            return $users->getSet($friends, "u.userid", ["u.userid", "u.username", "u.name"])->toArray();
        }return null;
    }

    public function loadOnlineFriends($userid) {
        return $this->getAdapter()->fetchAll($this->getAdapter()->select()->from(["u" => $this->dbprefix . "users"], ["userid", "name", "username"])
                                ->joinLeft(["pi" => $this->dbprefix . "gallery_images"], "pi.id = u.profileImage", "filename AS pimg")
                                ->where("u.userid IN (" . new \Zend_Db_Expr($this->getAdapter()->select()
                                        ->from($this->dbprefix . "relations", new \Zend_Db_Expr("(CASE WHEN sender = " . $userid . " THEN receiver WHEN receiver = " . $userid . " THEN sender END)"))
                                        ->where("status > 0")
                                        ->where("sender=? OR receiver = ? ", $userid)) . ")")
                                ->where(new \Zend_Db_Expr("u.lastAction BETWEEN DATE_SUB(NOW() , INTERVAL 8600 MINUTE) AND NOW()"))
                                ->where("u.chat_available = 1")
        );
    }

}
