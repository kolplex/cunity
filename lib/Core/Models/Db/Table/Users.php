<?php

namespace Core\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;
use Core\Models\Generator\Unique;
use Register\View\VerifyMail;

class Users extends Table {

    protected $_name = 'users';
    protected $_primary = 'userid';
    protected $_rowClass = "\Core\Models\Db\Row\User";

    public function __construct() {
        parent::__construct();
    }

    public function registerNewUser(array $data) {
        $salt = Unique::createSalt(25);
        $name = (\Core\Cunity::get("settings")->getSetting("fullname") ? $data['firstname'] . " " . $data['lastname'] : $data['username']);
        $result = $this->insert([
            "email" => trim($data['email']),
            "userhash" => $this->createUniqueHash(),
            "username" => $data['username'],
            "groupid" => 0,
            "password" => sha1(trim($data['password']) . $salt),
            "salt" => $salt,
            "name" => $name,
            "firstname" => $data['firstname'],
            "lastname" => $data['lastname'],
            "sex" => $data['sex']
        ]);
        if ($result) {
            new VerifyMail(["name" => $name, "email" => $data['email']], $salt);
            return true;
        }
        return false;
    }

    private function createUniqueHash() {
        $str = Unique::createSalt(32);
        if ($this->search("userhash", $str) !== NULL)
            return $this->createUniqueHash();
        else
            return $str;
    }

    public function search($key, $value) {
        return $this->fetchRow($this->select()->where($this->getAdapter()->quoteIdentifier($key) . " = ?", $value));
    }

    public function get($userid, $key = "userid") {        
        $res = $this->fetchRow($this->select()->setIntegrityCheck(false)
                        ->from(["u" => $this->dbprefix . "users"])
                        ->joinLeft(["fr" => $this->dbprefix . "relations"], "(fr.sender = u.userid OR fr.receiver = u.userid) AND status = 2", new \Zend_Db_Expr("COUNT(DISTINCT fr.relation_id) AS friendscount"))
                        ->joinLeft(["a" => $this->dbprefix . "gallery_albums"], "u.userid=a.userid AND (((a.privacy = 2 OR (a.privacy = 1 AND a.userid IN (" . new \Zend_Db_Expr($this->getAdapter()->select()->from($this->dbprefix . "relations", new \Zend_Db_Expr("(CASE WHEN sender = " . $_SESSION['user']->userid . " THEN receiver WHEN receiver = " . $_SESSION['user']->userid . " THEN sender END)"))->where("status > 0")->where("sender=?", $_SESSION['user']->userid)->orWhere("receiver=?", $_SESSION['user']->userid)) . "))) AND a.photo_count > 0) OR a.userid = " . $_SESSION['user']->userid . " )", new \Zend_Db_Expr("COUNT(DISTINCT a.id) AS albumscount"))
                        ->joinLeft(["p" => $this->dbprefix . "privacy"], "p.userid=u.userid", new \Zend_Db_Expr("GROUP_CONCAT(CONCAT(p.type,':',p.value)) AS privacy"))
                        ->joinLeft(["r" => $this->dbprefix . "relations"], "(r.receiver = " . $this->getAdapter()->quote($_SESSION['user']->userid) . " AND r.sender = u.userid) OR (r.sender = " . $this->getAdapter()->quote($_SESSION['user']->userid) . " AND r.receiver = u.userid)")
                        ->joinLeft(["pi" => $this->dbprefix . "gallery_images"], "pi.id = u.profileImage", ['filename AS pimg', 'albumid AS palbumid'])
                        ->joinLeft(["ti" => $this->dbprefix . "gallery_images"], "ti.id = u.titleImage", ["filename AS timg", "albumid AS talbumid"])
                        ->where("u." . $key . " = ?", $userid)
        );
        $res->privacy = \Core\Models\Generator\Privacy::parse($res->privacy);
        return $res;
    }

    public function getSet(array $userids, $key = "u.userid", array $fields = ["*"], $includeOwn = false) {
        $query = $this->select()->setIntegrityCheck(false)->from(["u" => $this->dbprefix . "users"], $fields)
                ->joinLeft(["r" => $this->dbprefix . "relations"], "(r.receiver = " . $this->getAdapter()->quote($_SESSION['user']->userid) . " AND r.sender = u.userid) OR (r.sender = " . $this->getAdapter()->quote($_SESSION['user']->userid) . " AND r.receiver = u.userid)")
                ->joinLeft(["pi" => $this->dbprefix . "gallery_images"], "pi.id = u.profileImage", ['filename AS pimg', 'albumid AS palbumid'])
                ->joinLeft(["ti" => $this->dbprefix . "gallery_images"], "ti.id = u.titleImage", ["filename AS timg", "albumid AS talbumid"])
                ->joinLeft(["p" => $this->dbprefix . "privacy"], "p.userid=u.userid", new \Zend_Db_Expr("GROUP_CONCAT(CONCAT(p.type,':',p.value)) AS privacy"))
                ->group("u.userid")
                ->where("u.groupid > 0");
        if (!$includeOwn)
            $query->where("u.userid != ?", $_SESSION['user']->userid);
        if (!empty($userids))
            $query->where($key . " IN(?)", $userids);
        // echo $query->__toString();
        $res = $this->fetchAll($query);
        for ($i = 0; $i < count($res); $i++)
            $res[$i]->privacy = \Core\Models\Generator\Privacy::parse($res[$i]->privacy);

        return $res;
    }

    public function getSetIn(array $userids, array $in, $key = "userid", $keyIn = "userid", array $fields = ["*"]) {
        $query = $this->select()->setIntegrityCheck(false)
                ->from(["u" => $this->dbprefix . "users"], $fields)
                ->joinLeft(["r" => $this->dbprefix . "relations"], "(r.receiver = " . $this->getAdapter()->quote($_SESSION['user']->userid) . " AND r.sender = u.userid) OR (r.sender = " . $this->getAdapter()->quote($_SESSION['user']->userid) . " AND r.receiver = u.userid)")
                ->joinLeft(["pi" => $this->dbprefix . "gallery_images"], "pi.id = u.profileImage", ['filename AS pimg', 'albumid AS palbumid'])
                ->joinLeft(["ti" => $this->dbprefix . "gallery_images"], "ti.id = u.titleImage", ["filename AS timg", "albumid AS talbumid"])
                ->joinLeft(["p" => $this->dbprefix . "privacy"], "p.userid=u.userid", new \Zend_Db_Expr("GROUP_CONCAT(CONCAT(p.type,':',p.value)) AS privacy"))
                ->where("u." . $key . " IN(?)", $userids)
                ->where("u.groupid > 0")
                ->where("u." . $keyIn . " IN(?)", $in)
                ->group("u.userid");
        $res = $this->fetchAll($query);
        for ($i = 0; $i < count($res); $i++)
            $res[$i]->privacy = \Core\Models\Generator\Privacy::parse($res[$i]->privacy);

        return $res;
    }

    public function exists($userid) {
        return ($this->get($userid) !== NULL);
    }

}
