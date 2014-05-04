<?php

namespace Messages\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Messages extends Table {

    protected $_name = 'messages';
    protected $_primary = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function deleteByUser($userid, $cid) {
        return (0 < $this->delete([$this->getAdapter()->quoteInto("sender=?", $userid), $this->getAdapter()->quoteInto("conversation=?", $cid)]));
    }

    public function loadByConversation($conversation_id, $offset = 0, $refresh = 0) {
        $query = $this->getAdapter()->select()
                ->from($this->dbprefix . "messages AS m")
                ->where("conversation = ?", $conversation_id)
                ->join($this->dbprefix . "users AS us", "m.sender = us.userid", ["us.username", "us.name"])
                ->joinLeft($this->dbprefix . "gallery_images AS img", "img.id = us.profileImage", ["filename AS pimg"])
                ->order("time DESC");

        if ($refresh > 0)
            $query->where("m.id > ?", $refresh);
        else
            $query->limit(20, $offset);
        return $this->getAdapter()->fetchAll($query);
    }

    public function insert(array $data) {
        $conversation = new Conversations();
        $conversation->markAsUnRead($data['conversation']);
        return parent::insert($data);
    }

}
