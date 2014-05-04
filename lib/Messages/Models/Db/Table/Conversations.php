<?php

namespace Messages\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Conversations extends Table {

    protected $_name = 'conversations';

    public function __construct() {
        parent::__construct();
    }

    public function getNewConversationId() {
        $res = $this->fetchRow($this->select()->from($this, new \Zend_Db_Expr("MAX(conversation_id) as max")));
        if ($res === NULL)
            return 1;
        return $res->max + 1;
    }

    public function getConversationIds() {
        $res = $this->fetchRow($this->select()->from($this, new \Zend_Db_Expr("GROUP_CONCAT(conversation_id) AS c"))->where("userid=?", $_SESSION['user']->userid))->toArray();
        return $res['c'];
    }

    public function getConversationId($userid) {
        $query = $this->getAdapter()->select()->from(["a" => $this->dbprefix . "conversations"])->where("userid=?", $userid)->where(new \Zend_Db_Expr("(" . $this->getAdapter()->select()->from(["b" => $this->dbprefix . "conversations"], new \Zend_Db_Expr("COUNT(*) AS count"))->where("a.conversation_id=b.conversation_id") . ")") . "=2");
        if (!empty($this->getConversationIds()))
            $query->where("conversation_id IN (" . $this->getConversationIds() . ")");
        $res = $this->getAdapter()->fetchRow($query);
        if ($res === NULL)
            return 0;
        return $res['conversation_id'];
    }

    public function addUsersToConversation($cid, $users, $invitation = false) {
        if (is_array($users) && !empty($users)) {
            foreach ($users AS $user) {
                $this->insert(["userid" => intval($user), "conversation_id" => intval($cid)]);
                \Notifications\Models\Notifier::notify($user, $_SESSION['user']->userid, "addConversation", "index.php?m=messages&action=" . $cid);
            }
        } else {
            $this->insert(["userid" => intval($users), "conversation_id" => intval($cid)]);
            if ($invitation)
                \Notifications\Models\Notifier::notify($_POST['userid'], $_SESSION['user']->userid, "addConversation", "index.php?m=messages&action=" . $cid);
            else
                \Notifications\Models\Notifier::notify($_POST['userid'], $_SESSION['user']->userid, "message", "index.php?m=messages&action=" . $cid);
        }
        return true;
    }

    public function markAsRead($conversation_id) {
        return $this->update(["status" => 0], [$this->getAdapter()->quoteInto("conversation_id=?", $conversation_id), $this->getAdapter()->quoteInto("userid = ?", $_SESSION['user']->userid)]);
    }

    public function markAsUnRead($conversation_id) {
        return $this->update(["status" => 1], [$this->getAdapter()->quoteInto("conversation_id=?", $conversation_id), $this->getAdapter()->quoteInto("userid != ?", $_SESSION['user']->userid)]);
    }

    public function deactivateConversation($conversation_id) {
        return $this->update(["status" => 2], [$this->getAdapter()->quoteInto("conversation_id=?", $conversation_id), $this->getAdapter()->quoteInto("userid != ?", $_SESSION['user']->userid)]);
    }

    public function loadConversationDetails($conversationid) {
        $result = $this->getAdapter()->fetchRow(
                $this->getAdapter()->select()
                        ->from(["c" => $this->dbprefix . "conversations"], ["(" .
                            new \Zend_Db_Expr($this->getAdapter()->select()
                            ->from(["u" => $this->dbprefix . "users"], new \Zend_Db_Expr("GROUP_CONCAT(u.userid)"))
                            ->where("u.userid IN (" .
                                    new \Zend_Db_Expr($this->getAdapter()->select()
                                    ->from(["uc" => $this->dbprefix . "conversations"], "uc.userid")
                                    ->where("uc.conversation_id = c.conversation_id")) . ")")) . ") AS users", "c.conversation_id", "(" .
                            new \Zend_Db_Expr($this->getAdapter()->select()->from($this->dbprefix . "messages AS cm", [new \Zend_Db_Expr("COUNT(*)")])->where("cm.conversation = c.conversation_id")) . ") AS count"
                        ])
                        ->where("c.conversation_id=?", intval($conversationid))->where("status < 2")->limit(1));
        return $result;
    }

    public function loadConversations($userid, $status = 0) {
        $query = $this->getAdapter()->select()
                ->from(
                        ["c" => $this->dbprefix . "conversations"], [
                    "c.status, (" . new \Zend_Db_Expr($this->getAdapter()->select()
                    ->from(["u" => $this->dbprefix . "users"], new \Zend_Db_Expr("GROUP_CONCAT(CONCAT(u.name,'|',u.userid))"))
                    ->where("u.userid != ?", $userid)
                    ->where("u.userid IN (" .
                            new \Zend_Db_Expr($this->getAdapter()->select()
                            ->from(["uc" => $this->dbprefix . "conversations"], "uc.userid")
                            ->where("uc.conversation_id = c.conversation_id")) . ")")) . ") AS users"
                ])
                ->where("c.userid=?", $userid)
                ->joinLeft(["m" => $this->dbprefix . "messages"], "m.conversation=c.conversation_id")
                ->join(["su" => $this->dbprefix . "users"], "m.sender = su.userid", "su.name AS sendername")
                ->where("m.time = (SELECT MAX(mt.time) FROM " . $this->dbprefix . "messages AS mt WHERE mt.conversation = c.conversation_id)")
                ->order("m.time DESC");
        if ($status == 0)
            $query->where("status<2");
        else
            $query->where("status = " . $status);
        $result = $result = $this->getAdapter()->fetchAll($query);
        return $result;
    }

    public function leave($userid, $cid) {
        return (0 < $this->delete([$this->getAdapter()->quoteInto("userid=?", $userid), $this->getAdapter()->quoteInto("conversation_id=?", $cid)]));
    }

}
