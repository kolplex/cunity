<?php

namespace Newsfeed\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Walls extends Table {

    protected $_name = 'walls';
    protected $_primary = 'wall_id';
    private $friendslistQuery = "";

    public function __construct() {
        parent::__construct();
        $this->friendslistQuery = \Friends\Models\Generator\FriendQuery::getFriendListQuery();
    }

    public function getWallId($ownerid, $ownertype) {
        $res = $this->fetchRow($this->select()->from($this, "wall_id")->where("owner_id=?", $ownerid)->where("owner_type=?", $ownertype)->limit(1));
        return $res['wall_id'];
    }

    public function getNewsfeed($offset, $refresh = 0, $filter = []) {
        $subquery = new \Zend_Db_Expr($this->select()->from($this, "wall_id")->where("owner_id IN (" . $this->friendslistQuery . ") OR owner_id = ?", $_SESSION['user']->userid)->where("owner_type = 'profile'"));
        $query = $this->getAdapter()->select()->from(["p" => $this->dbprefix . "posts"])
                ->join(["w" => $this->dbprefix . "walls"], "w.wall_id=p.wall_id")
                ->join(["u" => $this->dbprefix . "users"], "u.userid=p.userid", ["name", "username"])
                ->joinLeft(["img" => $this->dbprefix . "gallery_images"], "img.id=p.content AND p.type = 'image'", ["filename", "caption", "id AS refid"])
                ->joinLeft(["rus" => $this->dbprefix . "users"], "rus.userid=w.owner_id AND p.userid != w.owner_id", ["name AS receivername", "username AS receiverusername"])
                ->joinLeft(["pi" => $this->dbprefix . "gallery_images"], "pi.id = u.profileImage", "filename AS pimg")
                ->joinLeft(["co" => $this->dbprefix . "comments"], "CASE WHEN p.type != 'image' THEN co.ref_id = p.id ELSE co.ref_id = p.content END AND co.ref_name = p.type", "COUNT(DISTINCT co.id) AS commentcount")
                ->joinLeft(["li" => $this->dbprefix . "likes"], "CASE WHEN p.type != 'image' THEN li.ref_id = p.id ELSE li.ref_id = p.content END AND li.ref_name = p.type AND li.dislike = 0", "COUNT(DISTINCT li.id) AS likecount")
                ->joinLeft(["di" => $this->dbprefix . "likes"], "CASE WHEN p.type != 'image' THEN di.ref_id = p.id ELSE di.ref_id = p.content END AND di.ref_name = p.type AND di.dislike = 1", "COUNT(DISTINCT di.id) AS dislikecount")
                ->joinLeft(["ld" => $this->dbprefix . "likes"], "CASE WHEN p.type != 'image' THEN ld.ref_id = p.id ELSE ld.ref_id = p.content END AND ld.ref_name = p.type AND ld.userid = " . $this->getAdapter()->quote($_SESSION['user']->userid), "ld.dislike AS liked")
                ->where("p.wall_id IN (" . $subquery . ") OR p.wall_id IN (" . new \Zend_Db_Expr($this->getAdapter()->select()->from($this->dbprefix . "walls", "wall_id")->where("owner_id = ?", $_SESSION['user']->userid)->where("owner_type = 'profile'")) . ")")
                ->where("(w.owner_id=? AND w.owner_type = 'profile') OR p.privacy = 0 OR (p.privacy = 1 AND p.userid IN (" . new \Zend_Db_Expr($this->friendslistQuery) . "))", $_SESSION['user']->userid)
                ->group(new \Zend_Db_Expr("p.id"))
                ->order("p.id DESC");
        if (!empty($filter))
            $query->where("p.type IN (?)", $filter);
        if ($refresh > 0)
            $query->where("p.id > ?", $refresh);
        else
            $query->limit(20, $offset);
//var_dump($query->__toString());
        $res = $this->getAdapter()->fetchAll($query);
        foreach ($res AS &$result)
            if ($result['type'] == "video")
                $result['content'] = json_decode($result['content']);

        return $res;
    }

    public function getWall($ownerid, $ownertype, $offset, $refresh = 0, $filter = []) {
        $query = $this->getAdapter()->select()->from(["p" => $this->dbprefix . "posts"])
                ->join(["w" => $this->dbprefix . "walls"], "w.wall_id=p.wall_id")
                ->join(["u" => $this->dbprefix . "users"], "u.userid=p.userid", ["name", "username"])
                ->joinLeft(["img" => $this->dbprefix . "gallery_images"], "img.id=p.content AND p.type = 'image'", ["filename", "caption", "id AS refid"])
                ->joinLeft(["rus" => $this->dbprefix . "users"], "w.owner_type = 'profile' AND rus.userid=w.owner_id AND p.userid != w.owner_id AND w.owner_id != " . $ownerid, ["name AS receivername", "username AS receiverusername"])
                ->joinLeft(["pi" => $this->dbprefix . "gallery_images"], "pi.id = u.profileImage", "filename AS pimg")
                ->joinLeft(["co" => $this->dbprefix . "comments"], "CASE WHEN p.type != 'image' THEN co.ref_id = p.id ELSE co.ref_id = p.content END AND co.ref_name = p.type", "COUNT(DISTINCT co.id) AS commentcount")
                ->joinLeft(["li" => $this->dbprefix . "likes"], "CASE WHEN p.type != 'image' THEN li.ref_id = p.id ELSE li.ref_id = p.content END AND li.ref_name = p.type AND li.dislike = 0", "COUNT(DISTINCT li.id) AS likecount")
                ->joinLeft(["di" => $this->dbprefix . "likes"], "CASE WHEN p.type != 'image' THEN di.ref_id = p.id ELSE di.ref_id = p.content END AND di.ref_name = p.type AND di.dislike = 1", "COUNT(DISTINCT di.id) AS dislikecount")
                ->joinLeft(["ld" => $this->dbprefix . "likes"], "CASE WHEN p.type != 'image' THEN ld.ref_id = p.id ELSE ld.ref_id = p.content END AND ld.ref_name = p.type AND ld.userid = " . $this->getAdapter()->quote($_SESSION['user']->userid), "ld.dislike AS liked")
                ->where("(p.wall_id = (" . new \Zend_Db_Expr($this->select()->from($this, "wall_id")->where("owner_id = ?", intval($ownerid))->where("owner_type = ?", $ownertype)) . ")) OR p.userid = ? AND " . $this->getAdapter()->quote($ownertype) . " = 'profile'", $ownerid)
                ->where("(p.userid = ?) OR (w.owner_id = ? AND w.owner_type = " . $this->getAdapter()->quote($ownertype) . ") OR p.privacy = 0 OR (p.privacy = 1 AND p.userid IN (" . new \Zend_Db_Expr($this->friendslistQuery) . "))", intval($_SESSION['user']->userid))
                ->group("p.id")
                ->order("p.id DESC");
        if (!empty($filter))
            $query->where("p.type IN (?)", $filter);
        if ($refresh > 0)
            $query->where("p.id > ?", $refresh);
        else
            $query->limit(20, $offset);
//        var_dump($query->__toString());
        $res = $this->getAdapter()->fetchAll($query);
        foreach ($res AS &$result)
            if ($result['type'] == "video")
                $result['content'] = json_decode($result['content']);

        return $res;
    }

    public function createUserWall($userid) {
        return $this->insert(["owner_id" => $userid, "owner_type" => "profile"]);
    }

    public function deleteWallByOwner($ownerid, $ownertype) {
        $wallid = $this->getWallId($ownerid, $ownertype);
        $this->delete($this->getAdapter()->quoteInto("wall_id = ?", $wallid));
        $posts = new Posts();
        $posts->deletebyOwner($ownerid, $wallid);
    }

}
