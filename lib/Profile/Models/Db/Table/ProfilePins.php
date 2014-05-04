<?php

namespace Profile\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class ProfilePins extends Table {

    protected $_name = 'profile_pins';
    protected $_primary = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function getAllByUser($userid) {
        $pt = new Privacy();
        $res = $pt->checkPrivacy("visit",$userid);                        
        if ($res)            
            return $this->fetchAll($this->select()->where("userid=?", $userid)->order("row"));
        else
            return ["status" => true];
    }

    public function updatePosition($columns, $row, $pinid) {
        return $this->update(["column" => $columns, "row" => $row], $this->getAdapter()->quoteInto("id=?", $pinid));
    }

}
