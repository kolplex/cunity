<?php

namespace Likes\Models;

use Core\View\Ajax\View;

class Likes {

    private $table, $view;

    public function __construct($action) {
        $this->view = new View();
        if (!isset($_POST['ref_name']) || !isset($_POST['ref_id'])) {
            $this->view->setStatus(false);
        } else {
            $this->table = new Db\Table\Likes();
            if (method_exists($this, $action))
                call_user_func([$this, $action]);
        }
        $this->view->sendResponse();
    }

    private function like() {
        $res = $this->table->like($_POST['ref_id'], $_POST['ref_name']);
        $this->view->setStatus($res !== false);
        $this->view->addData($res);
    }

    private function dislike() {
        $res = $this->table->dislike($_POST['ref_id'], $_POST['ref_name']);
        $this->view->setStatus($res !== false);
        $this->view->addData($res);
    }

    private function unlike() {
        $res = $this->table->unlike($_POST['ref_id'], $_POST['ref_name']);
        $this->view->setStatus($res !== false);
        $this->view->addData($res);
    }

    private function get() {
        $res = $this->table->getLikes($_POST['ref_id'], $_POST['ref_name'], $_POST['dislike']);
        $this->view->setStatus($res !== false);
        $this->view->addData(["likes" => $res]);
    }

}
