<?php

namespace Forums\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Forums extends Table {

    protected $_name = 'forums';
    protected $_primary = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function loadForums() {
        $query = $this->getAdapter()->select()->from(["f" => $this->dbprefix . "forums"])
                ->joinLeft(["b" => $this->dbprefix . "forums_boards"], "b.forum_id=f.id", new \Zend_Db_Expr("COUNT(b.id) AS boardcount"))
                ->where("f.owner_id IS NULL")
                ->where("f.owner_type IS NULL")
                ->group("f.id");
        return $this->getAdapter()->fetchAll($query);
    }

    public function loadForumData($id) {
        if (is_array($id) && isset($id['owner_id']) && isset($id['owner_type'])) {
            $res = $this->fetchRow($this->select()->where("owner_id=?", $id['owner_id'])->where("owner_type=?", $id['owner_type']));
        } else {
            $res = $this->find($id)->current();
        }
        return ($res !== NULL) ? $res : false;
    }

    public function add(array $data) {
        $res = $this->insert($data);
        if ($res !== false)
            return array_merge(["id" => $res], $data);
        return false;
    }

    public function deleteForum($id) {
        $boards = new Boards;
        if ($boards->deleteBoardsByForumId($id))
            return ($this->delete($this->getAdapter()->quoteInto("id=?", $id)) > 0);
        return false;
    }

}
