<?php

namespace Forums\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Posts extends Table {

    protected $_name = 'forums_posts';
    protected $_primary = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function loadPosts($thread_id, $limit = 20, $offset = 0) {
        $query = $this->getAdapter()->select()->from(["p" => $this->_name])
                ->joinLeft(["u" => $this->dbprefix . "users"], "u.userid=.p.userid", ["name", "username"])
                ->joinLeft(["pi" => $this->dbprefix . "gallery_images"], "pi.id=u.profileImage", ["filename"])
                ->joinLeft(["pc" => $this->dbprefix . "forums_posts"], "pc.thread_id=p.thread_id", new \Zend_Db_Expr("COUNT(DISTINCT pc.id) AS postcount"))
                ->where("p.thread_id=?", $thread_id)
                ->group("p.id")
                ->order("time")
                ->limit($limit, $offset);
        return $this->getAdapter()->fetchAll($query);
    }

    public function getPost($postid) {
        $query = $this->getAdapter()->select()->from(["p" => $this->_name])
                ->joinLeft(["u" => $this->dbprefix . "users"], "u.userid=.p.userid", ["name", "username"])
                ->joinLeft(["pi" => $this->dbprefix . "gallery_images"], "pi.id=u.profileImage", ["filename"])
                ->joinLeft(["pc" => $this->dbprefix . "forums_posts"], "pc.thread_id=p.thread_id", new \Zend_Db_Expr("COUNT(DISTINCT pc.id) AS postcount"))
                ->where("p.id=?", $postid);
        return $this->getAdapter()->fetchRow($query);
    }

    public function post(array $data) {
        $res = $this->insert(array_merge($data, ["userid" => $_SESSION['user']->userid]));
        if ($res !== false)
            return $this->getPost($res);
        return false;
    }

    public function deletePost($postid) {
        return ($this->delete($this->getAdapter()->quoteInto("id=?", $postid)) > 0);
    }

}
