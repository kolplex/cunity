<?php

namespace Friends\Models;

class FriendShipController {

    public function __construct() {
        if (method_exists($this, $_GET['action'])) {
            call_user_func([$this, $_GET['action']]);
        }
    }

    private function add() {
        if (!isset($_POST['userid']))
            new \Core\Exception("No userid given!");
        else {
            $relations = new Db\Table\Relationships();
            $res = $relations->insert(["sender" => $_SESSION['user']->userid, "receiver" => $_POST['userid'], "status" => 1]);
            if ($res) {
                $view = new \Core\View\Ajax\View($res !== false);
                $view->sendResponse();
            }
        }
    }

    private function block() {
        if (!isset($_POST['userid']))
            new \Core\Exception("No userid given!");
        else {
            $relations = new Db\Table\Relationships();
            $res = $relations->updateRelation($_SESSION['user']->userid, $_POST['userid'], ["status" => 0, "sender" => $_SESSION['user']->userid, "receiver" => $_POST['userid']]);
            if ($res) {
                $view = new \Core\View\Ajax\View($res !== false);
                $view->sendResponse();
            }
        }
    }

    private function confirm() {
        if (!isset($_POST['userid'])) // Here the userid is the relation id to make it easier to identify the friendship!
            new \Core\Exception("No userid given!");
        else {
            $relations = new Db\Table\Relationships();
            $res = $relations->updateRelation($_SESSION['user']->userid, $_POST['userid'], ["status" => 2]);
            if ($res) {
                $view = new \Core\View\Ajax\View($res !== false);
                $view->sendResponse();
            }
        }
    }

    private function remove() {
        if (!isset($_POST['userid'])) // Here the userid is the relation id to make it easier to identify the friendship!
            new \Core\Exception("No userid given!");
        else {
            $relations = new Db\Table\Relationships();
            $res = $relations->deleteRelation($_SESSION['user']->userid, $_POST['userid']);
            if ($res) {
                $view = new \Core\View\Ajax\View($res !== false);
                $view->sendResponse();
            }
        }
    }

    private function change() {
        if (!isset($_POST['userid'])) // Here the userid is the relation id to make it easier to identify the friendship!
            new \Core\Exception("No userid given!");
        else {
            $relations = new Db\Table\Relationships();
            $res = $relations->updateRelation($_POST['userid'], $_SESSION['user']->userid, ["status" => $_POST['status']]);
            if ($res) {
                $view = new \Core\View\Ajax\View($res !== false);
                $view->sendResponse();
            }
        }
    }

    private function loadData() {
        $userid = $_POST['userid'];
        $users = $_SESSION['user']->getTable();
        $result = $users->get($userid);
        if ($result === NULL)
            throw new \Core\Exception("No User found with the given ID!");
        else {
            $view = new \Core\View\Ajax\View(true);
            $view->addData(["user" => $result->toArray(["pimg", "username", "firstname", "lastname"])]);
            $view->sendResponse();
        }
    }

    private function load() {
        $relations = new Db\Table\Relationships();
        $userid = ($_POST['userid'] == 0) ? $_SESSION['user']->userid : $_POST['userid'];
        $rows = $relations->getFullFriendList(">1", $userid);
        $view = new \Core\View\Ajax\View(true);
        $view->addData(["result" => $rows]);
        $view->sendResponse();
    }

}
