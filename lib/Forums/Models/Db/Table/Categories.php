<?php

namespace Forums\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Categories extends Table {

    protected $_name = 'forums_categories';
    protected $_primary = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function getCategories() {
        $query = $this->getAdapter()->select()->from(["c" => $this->_name])
                ->joinLeft(["t" => $this->dbprefix . "forums_threads"], "t.category=c.id", new \Zend_Db_Expr("COUNT(DISTINCT t.id) AS threadCount"))
                ->joinLeft(["pc" => $this->dbprefix . "forums_posts"], "pc.thread_id=t.id", new \Zend_Db_Expr("COUNT(DISTINCT pc.id) AS postcount"))
                ->group("c.id");
        $res = $this->getAdapter()->fetchAll($query);
        if ($res !== NULL && $res !== false)
            return $res;
        return false;
    }

    public function getCategoryData($tag) {
        $res = $this->fetchRow($this->select()->where("tag=?", $tag));
        if ($res !== NULL && $res !== false)
            return $res->toArray();
        return false;
    }

}
