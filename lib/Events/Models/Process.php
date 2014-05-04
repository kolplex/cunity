<?php

namespace Events\Models;

use Events\Models\Db\Table\Events;
use Events\Models\Db\Table\Guests;
use Core\View\Ajax\View;

class Process {

    public function __construct($action) {
        if (method_exists($this, $action))
            call_user_func([$this, $action]);
    }

    private function createEvent() {
        $events = new Events;
        $result = false;
        echo new \Zend_Db_Expr("DATE_FORMAT('" . $_POST['start'] . "','%d-%m-%Y %H:%i:%s')");
        $res = $events->addEvent([
            "userid" => $_SESSION['user']->userid,
            "title" => $_POST['title'],
            "description" => $_POST['description'],
            "place" => $_POST['place'],
            "start" => $_POST['start'],
            "imageId" => 0,
            "type" => "event",
            "privacy" => $_POST['privacy'],
            "guest_invitation" => (isset($_POST['guest_invitation'])) ? 1 : 0
        ]);
        if ($res > 0) {
            $guests = new Guests;
            $result = $guests->addGuests([["userid" => $_SESSION['user']->userid, "eventid" => $res, "status" => 1]]);
        }

        $view = new View($result);
        if ($result)
            $view->addData($events->getEventData($res));
        $view->sendResponse();
    }

    private function loadEvents() {
        $start = date("Y-m-d H:i:s", ($_GET['from'] / 1000));
        $end = date("Y-m-d H:i:s", ($_GET['to'] / 1000));

        $events = new Events;
        $result = $events->fetchBetween($start, $end);
        $view = new View($result !== NULL);
        $view->addData([
            "success" => ($result !== NULL) ? 1 : 0,
            "result" => $result
        ]);
        $view->sendResponse();
    }

    private function loadEvent() {
        $events = new Events;
        $guests = new Guests;
        $id = explode("-", $_GET['action']);
        $view = new \Events\View\Event;
        $forums = new \Forums\Models\Db\Table\Forums;
        $data = $events->getEventData($id[0]);
        $data['date'] = new \DateTime($data['start']);
        $data['guests'] = $guests->getGuests($id[0]);
        $forumData = $forums->loadForumData(["owner_id" => $id[0], "owner_type" => "event"]);
        $view->assign("event", $data);
        $view->assign("forum", $forumData);
        $view->show();
    }

}
