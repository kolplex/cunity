<?php

namespace Comments\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Comments extends Table {

    protected $_name = 'comments';
    protected $_primary = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function addComment($referenceId, $referenceName, $content) {
        $res = $this->insert(["ref_id" => $referenceId, "ref_name" => $referenceName, "userid" => $_SESSION['user']->userid, "content" => $content]);
        if ($res !== NULL)
            return $this->getComment($res);
        else
            return ["status" => false];
    }

    public function removeComment($commentid) {
        return $this->delete($this->getAdapter()->quoteInto("id = ?", $commentid));
    }

    public function removeAllComments($referenceId, $referenceName) {
        return $this->delete($this->getAdapter()->quoteInto("ref_id = ? AND ref_name = ?", [intval($referenceId), $referenceName]));
    }

    public function getComment($commentid) {
        return $this->getAdapter()->fetchRow($this->getAdapter()->select()->from(["c" => $this->dbprefix . "comments"], ["id", "content", "time", "userid"])->joinLeft(["u" => $this->dbprefix . "users"], "u.userid = c.userid", ["username", "name"])->joinLeft(["i" => $this->dbprefix . "gallery_images"], "u.profileImage = i.id", ["filename"])->where("c.id = ?", $commentid));
    }

    public function get($referenceId, $referenceName, $last = false, $limit = 20) {
        $query = $this->getAdapter()->select()->from(["c" => $this->dbprefix . "comments"])->joinLeft(["u" => $this->dbprefix . "users"], "u.userid = c.userid", ["username", "name"])->joinLeft(["i" => $this->dbprefix . "gallery_images"], "u.profileImage = i.id", ["filename"])->where("c.ref_id = ?", $referenceId)->where("c.ref_name = ?", $referenceName)->order("c.time DESC")->limit($limit);
        if ($last)
            $query->where("c.id < ?", $last);
        return $this->getAdapter()->fetchAll($query);
    }

}
