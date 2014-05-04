<?php

namespace Forums\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Threads extends Table {

    protected $_name = 'forums_threads';
    protected $_primary = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function loadThreads($boardid) {
        $res = $this->getAdapter()->fetchAll($this->getAdapter()->select()
                        ->from(["t" => $this->dbprefix . "forums_threads"])
                        ->joinLeft(["p" => $this->dbprefix . "forums_posts"], "p.thread_id=t.id", ["time"])
                        ->joinLeft(["pc" => $this->dbprefix . "forums_posts"], "pc.thread_id=t.id", new \Zend_Db_Expr("COUNT(DISTINCT pc.id) AS postcount"))
                        ->joinLeft(["u" => $this->dbprefix . "users"], "u.userid=p.userid", ["name", "username"])
                        ->joinLeft(["c" => $this->dbprefix . "forums_categories"], "c.id=t.category", ["name AS categoryName", "tag AS categoryTag"])
                        ->order("t.important DESC")
                        ->order("p.time DESC")
                        ->where("pc.id IS NOT NULL")
                        ->where("t.board_id=?", $boardid)
                        ->group("t.id"));
        if ($res !== NULL && $res !== false)
            return $res;
        return false;
    }

    public function loadCategoryThreads($category) {
        $res = $this->getAdapter()->fetchAll($this->getAdapter()->select()
                        ->from(["t" => $this->dbprefix . "forums_threads"])
                        ->joinLeft(["p" => $this->dbprefix . "forums_posts"], "p.thread_id=t.id", ["time"])
                        ->joinLeft(["pc" => $this->dbprefix . "forums_posts"], "pc.thread_id=t.id", new \Zend_Db_Expr("COUNT(DISTINCT pc.id) AS postcount"))
                        ->joinLeft(["u" => $this->dbprefix . "users"], "u.userid=p.userid", ["name", "username"])
                        ->joinLeft(["c" => $this->dbprefix . "forums_categories"], "c.id=t.category", ["name AS categoryName", "tag AS categoryTag"])
                        ->order("t.important DESC")
                        ->order("p.time DESC")
                        ->where("t.category=?", $category)
                        ->group("t.id"));
        if ($res !== NULL && $res !== false)
            return $res;
        return false;
    }

    public function loadThreadData($id) {
        $res = $this->getAdapter()->fetchRow($this->getAdapter()->select()->from(["t" => $this->_name])
                        ->joinLeft(["b" => $this->dbprefix . "forums_boards"], "b.id=t.board_id", ["forum_id", new \Zend_Db_Expr("b.title as boardtitle")])
                        ->joinLeft(["pc" => $this->dbprefix . "forums_posts"], "pc.thread_id=t.id", new \Zend_Db_Expr("COUNT(DISTINCT pc.id) AS postcount"))
                        ->joinLeft(["f" => $this->dbprefix . "forums"], "f.id=b.forum_id", [new \Zend_Db_Expr("f.title as forumtitle")])
                        ->where("t.id=?", $id));
        if ($res == NULL || $res["id"] == NULL)
            return false;
        return $res;
    }

    public function deleteThread($id) {
        $posts = new Posts;
        $r = $posts->delete($posts->getAdapter()->quoteInto("thread_id=?", $id));
        if ($r !== false)
            return ($this->delete($this->getAdapter()->quoteInto("id=?", $id)) > 0);
        else
            return false;
    }

    public function deleteThreadsByBoardId($id) {
        $result = [];
        $res = $this->fetchAll($this->select()->where("board_id=?", $id));
        foreach ($res AS $r)
            $result[] = $this->deleteThread($r->id);
        return !in_array(false, $result);
    }

}
