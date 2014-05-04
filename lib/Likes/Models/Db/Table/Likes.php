<?php

namespace Likes\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Likes extends Table {

    protected $_name = 'likes';
    protected $_primary = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function getLike($referenceId, $referenceName) {
        return $this->fetchRow($this->select()->from($this, ["id", "dislike"])->where("ref_id=?", $referenceId)->where("ref_name=?", $referenceName)->where("userid=?", $_SESSION['user']->userid));
    }

    public function countLikes($referenceId, $referenceName) {
        $likes = $this->fetchRow($this->select()->from($this, new \Zend_Db_Expr("COUNT(*) AS c"))->where("ref_name=?", $referenceName)->where("ref_id=?", $referenceId)->where("dislike=0"));
        $dislikes = $this->fetchRow($this->select()->from($this, new \Zend_Db_Expr("COUNT(*) AS c"))->where("ref_name=?", $referenceName)->where("ref_id=?", $referenceId)->where("dislike=1"));
        return ["dislikes" => $dislikes['c'], "likes" => $likes['c']];
    }

    public function getLikes($referenceId, $referenceName, $dislike = 0) {
        return $this->getAdapter()->fetchAll($this->getAdapter()->select()->from(["l" => $this->dbprefix . "likes"])->joinLeft(["u" => $this->dbprefix . "users"], "u.userid=l.userid", ["username", "name"])->joinLeft(["i" => $this->dbprefix . "gallery_images"], "i.id=u.profileImage", "filename")->where("ref_name=?", $referenceName)->where("ref_id=?", $referenceId)->where("dislike=?", $dislike));
    }

    public function like($referenceId, $referenceName) {
        $res = $this->getLike($referenceId, $referenceName);
        if ($res != NULL && $res->dislike == 1) {
            $res->dislike = 0;
            if ($res->save())
                return $this->countLikes($referenceId, $referenceName);
        }else if ($this->insert(["ref_id" => $referenceId, "ref_name" => $referenceName, "userid" => $_SESSION['user']->userid]) !== NULL)
            return $this->countLikes($referenceId, $referenceName);
        return false;
    }

    public function dislike($referenceId, $referenceName) {
        $res = $this->getLike($referenceId, $referenceName);
        if ($res != NULL && $res->dislike == 0) {
            $res->dislike = 1;
            if ($res->save())
                return $this->countLikes($referenceId, $referenceName);
        }else if ($this->insert(["ref_id" => $referenceId, "ref_name" => $referenceName, "dislike" => 1, "userid" => $_SESSION['user']->userid]) !== NULL)
            return $this->countLikes($referenceId, $referenceName);
        return false;
    }

    public function unlike($referenceId, $referenceName) {
        $res = $this->getLike($referenceId, $referenceName);
        if ($res->delete())
            return $this->countLikes($referenceId, $referenceName);
        return false;
    }

}
