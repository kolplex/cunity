<?php

namespace Notifications\Models;

class Process {

    public function get($type) {
        if ($type == "friends") {
            $relations = new \Friends\Models\Db\Table\Relationships();
            $rows = $relations->getFullFriendRequests($_SESSION['user']->userid);
            $view = new \Core\View\Ajax\View(true);
            $view->addData(["result" => $rows]);
            $view->sendResponse();
        } else if ($type == "messages") {
            $relations = new \Messages\Models\Process("loadUnread");
        } else if ($type == "general") {
            $n = new \Notifications\Models\Db\Table\Notifications();
            $res = $n->getNotifications();
            $view = new \Core\View\Ajax\View(true);
            $view->addData(["result" => $res["all"],"new"=>$res["new"]]);
            $view->sendResponse();
        }
    }

}
