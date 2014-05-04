<?php

namespace Gallery\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Gallery_Albums extends Table {

    protected $_name = 'gallery_albums';
    protected $_primary = 'id';
    protected $_rowClass = "\Gallery\Models\Db\Row\Album";

    public function __construct() {
        parent::__construct();
    }

    public function exists($albumid) {
        $res = $this->fetchRow($this->select()->from($this, "COUNT(albumid) AS count")->where("albumid=?", $albumid));
        return ($res->count > 0);
    }

    public function newProfileAlbums($userid) {
        return $this->insert(["userid" => $userid, "type" => "profile"]);
    }

    public function newNewsfeedAlbums($userid) {
        return $this->insert(["userid" => $userid, "type" => "newsfeed"]);
    }

    public function search($field, $value) {
        return $this->fetchRow($this->select()->where($this->getAdapter()->quoteIdentifier($field) . " = ?", $value));
    }

    public function getAlbumData($albumid) {
        return $this->fetchAll($this->select()->setIntegrityCheck(false)->from(["a" => $this->dbprefix . "gallery_albums"])->joinLeft(["u" => $this->dbprefix . "users"], "a.userid=u.userid", ["name", "username"])->joinLeft(["i" => $this->dbprefix . "gallery_images"], "i.id=u.profileImage", "filename")->where("a.id=?", $albumid));
    }

    public function loadAlbums($userid) {
        if ($userid == 0) {
            return $this->getAdapter()->fetchAll(
                            $this->getAdapter()->select()
                                    ->from(["a" => $this->info("name")])
                                    ->joinLeft(["i" => $this->dbprefix . "gallery_images"], "a.cover=i.id", "filename")
                                    ->joinLeft(["u" => $this->dbprefix . "users"], "a.userid=u.userid", ["u.name", "u.username"])
                                    ->joinLeft(["pi" => $this->dbprefix . "gallery_images"], "pi.id=u.profileImage", "pi.filename as pimg")
                                    ->where("(a.photo_count > 0) AND ((a.type IS NULL OR a.type = 'shared') AND (a.privacy = 2 OR (a.privacy = 1 AND a.userid IN (" . new \Zend_Db_Expr($this->getAdapter()->select()->from($this->dbprefix . "relations", new \Zend_Db_Expr("(CASE WHEN sender = " . $_SESSION['user']->userid . " THEN receiver WHEN receiver = " . $_SESSION['user']->userid . " THEN sender END)"))->where("status > 0")->where("sender=?", $_SESSION['user']->userid)->orWhere("receiver=?", $_SESSION['user']->userid)) . "))) OR a.userid=?)",$_SESSION['user']->userid)
                                    ->order("i.time DESC")
            );
        } else {
            return $this->getAdapter()->fetchAll(
                            $this->getAdapter()->select()
                                    ->from(["a" => $this->info("name")])                                    
                                    ->joinLeft(["i" => $this->dbprefix . "gallery_images"], "a.cover=i.id", "filename")
                                    ->joinLeft(["u" => $this->dbprefix . "users"], "a.userid=u.userid", ["u.name", "u.username"])
                                    ->joinLeft(["pi" => $this->dbprefix . "gallery_images"], "pi.id=u.profileImage", "pi.filename as pimg")
                                    ->where("a.photo_count > 0")
                                    ->where("(a.privacy = 2 OR (a.privacy = 1 AND a.userid IN (" . new \Zend_Db_Expr($this->getAdapter()->select()->from($this->dbprefix . "relations", new \Zend_Db_Expr("(CASE WHEN sender = " . $_SESSION['user']->userid . " THEN receiver WHEN receiver = " . $_SESSION['user']->userid . " THEN sender END)"))->where("status > 0")->where("sender=?", $_SESSION['user']->userid)->orWhere("receiver=?", $_SESSION['user']->userid)) . ")) OR a.userid=?)",$_SESSION['user']->userid)
                                    ->where("a.userid=?", $userid)
                                    ->order("i.time DESC")
            );
        }
    }

    public function deleteAlbumsByUser($userid) {
        $albums = $this->fetchAll($this->select()->where("userid=?", $userid));
        foreach ($albums AS $album) {
            $album->deleteAlbum();
        }
    }

}
