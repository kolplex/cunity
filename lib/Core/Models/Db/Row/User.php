<?php

namespace Core\Models\Db\Row;

use \Gallery\Models\Db\Table\Gallery_Images;
use \Friends\Models\Db\Table\Relationships;

class User extends \Zend_Db_Table_Row_Abstract {

    protected $images = [];
    public $friends = [];
    
    public function init() {
        parent::init();
    }

    public function passwordMatch($password) {
        return (sha1($password . $this->salt) == $this->password);
    }

    public function setLogin($cookie = false) {
        if ($cookie)
            $this->setCookie();
        $this->password_token = NULL;
        $this->save();
        $_SESSION['loggedIn'] = true;
        $_SESSION['user'] = $this;
    }

    public function logout() {
        session_destroy();
        setcookie("cunity-login", base64_encode($this->username), time() - 3600,'/',\Core\Cunity::get("settings")->getSetting("siteurl"));
        setcookie("cunity-login-token", md5($this->salt . "-" . $this->registered . "-" . $this->userhash), time() - 3600,'/',\Core\Cunity::get("settings")->getSetting("siteurl"));                
    }

    public function getProfileImages() {
        if ($this->images !== null)
            return $this->images;
        $images = new Gallery_Images();
        $this->images = $images->fetchAll($images->select()->where("id=?", $this->profileImage)->orWhere("id=?", $this->titleImage));
        return $this->images;
    }

    public function getFriendList() {
        $rel = new Relationships();
        return $rel->getFriendList(">1", $this->userid);
    }

    public function getRelationship($user = 0) {
        if ($user == 0)
            $user = $_SESSION['user']->userid;
        $rel = new Relationships();
        $result = $rel->getRelation($this->userid, $user);
        if ($result == NULL)
            return [];
        else
            return $result->toArray();
    }
    
    public function isFriend($user=0){
        $r = $this->getRelationship($user);
        if(!empty($r) && $r["status"] == 2)
            return true;
        return false;
    }

    private function setCookie() {
        $expire = time() + 3600 * 24 * 30;
        setcookie("cunity-login", base64_encode($this->username), $expire,'/',\Core\Cunity::get("settings")->getSetting("siteurl"));
        setcookie("cunity-login-token", md5($this->salt . "-" . $this->registered . "-" . $this->userhash), $expire,'/',\Core\Cunity::get("settings")->getSetting("siteurl"));        
    }

    public function toArray(array $args = []) {
        if (empty($args))
            return parent::toArray();
        $result = [];
        foreach ($args AS $v)
            $result[$v] = $this->_data[$v];
        return $result;
    }

    public function isAdmin() {
        return $this->groupid == 3;
    }

    public function save() {
        if (isset($this->_modifiedFields['username']) ||
                isset($this->_modifiedFields['firstname']) ||
                isset($this->_modifiedFields['lastname'])) {
            $currentUsername = $this->username;
            $result = parent::save();
            $searchindex = new \Search\Models\Process();
            return $result && $searchindex->updateUser($currentUsername, $this->username, $this->firstname . " " . $this->lastname);
        } else
            return parent::save();
    }

    public function __wakeup() {
        if ($this->_table == null)
            $this->setTable(new \Core\Models\Db\Table\Users());
        $this->lastAction = new \Zend_Db_Expr("UTC_TIMESTAMP()");
        $this->save();
    }

}
