<?php

namespace Forums\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Boards extends Table {

    protected $_name = 'forums_boards';
    protected $_primary = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function loadBoards($forumid, $limit = 20, $offset = 0) {
        $res = $this->getAdapter()->fetchAll($this->getAdapter()->select()
                        ->from(["b" => $this->_name])
                        ->joinLeft(["t" => $this->dbprefix . "forums_threads"], "t.board_id=b.id", [""])
                        ->joinLeft(["th" => $this->dbprefix . "forums_threads"], "th.board_id=b.id", new \Zend_Db_Expr("COUNT(th.id) AS threadcount"))
                        ->joinLeft(["p" => $this->dbprefix . "forums_posts"], "p.thread_id=t.id", ["time"])
                        ->order("t.time DESC")
                        ->where("b.forum_id=?", $forumid)->limit($limit, $offset)->group("b.id"));
        if ($res !== NULL && $res !== false)
            return $res;
        return false;
    }

    public function loadBoardData($id) {
        $res = $this->getAdapter()->fetchRow($this->getAdapter()->select()->from(["b" => $this->_name])
                        ->joinLeft(["f" => $this->dbprefix . "forums"], "f.id=b.forum_id", [new \Zend_Db_Expr("f.title as parenttitle")])->where("b.id=?", $id));
        if($res == NULL || $res["id"] == NULL)
            return false;
        return $res;
    }

    public function add(array $data) {
        $res = $this->insert($data);
        if ($res !== false)
            return array_merge(["id" => $res], $data);
        return false;
    }

    public function deleteBoard($id) {
        $threads = new Threads;
        $r = $threads->deleteThreadsByBoardId($id);
        if ($r)
            return ($this->delete($this->getAdapter()->quoteInto("id=?", $id)) > 0);
        return false;
    }

    public function deleteBoardsByForumId($id) {
        $result = [];
        $res = $this->fetchAll($this->select()->where("forum_id=?", $id));
        foreach ($res AS $r)
            $result[] = $this->deleteBoard($r->id);
        return !in_array(false, $result);
    }

}
