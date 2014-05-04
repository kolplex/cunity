<?php

namespace Memberlist\Models;

class Process {

    public function getAll() {
        $table = new \Core\Models\Db\Table\Users();

        $result = $table->getSet([], "userid", ["username", "name","userid"]);
        $view = new \Core\View\Ajax\View($result !== NULL);
        $view->addData(["result" => $result->toArray()]);
        $view->sendResponse(); 
    }

}
