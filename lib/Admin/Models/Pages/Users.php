<?php

namespace Admin\Models\Pages;

class Users extends PageAbstract {

    public function __construct() {
        $this->loadData();
        $this->render("users");
    }

    private function loadData() {       
        $users = new \Core\Models\Db\Table\Users();
        $this->assignments["users"] = $users->getSet([],"u.userid",["*"],true);
    }

}
