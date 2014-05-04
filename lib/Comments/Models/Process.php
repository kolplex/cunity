<?php

namespace Comments\Models;

use Core\View\Ajax\View;

class Process {

    private $table, $view;

    public function __construct($action) {
        $this->view = new View();
        $this->table = new Db\Table\Comments();
        if (method_exists($this, $action))
            call_user_func([$this, $action]);

        $this->view->sendResponse();
    }

    private function add() {
        $res = $this->table->addComment($_POST['ref_id'], $_POST['ref_name'], $_POST['content']);
        $this->view->setStatus($res !== false);
        $this->view->addData($res);
    }

    private function remove() {
        $res = $this->table->removeComment($_POST['comment_id']);
        $this->view->setStatus($res !== false);
    }

    private function removeAll() {
        $res = $this->table->removeAllComments($_POST['ref_id'], $_POST['ref_name']);
        $this->view->setStatus($res !== false);
    }

    private function get() {
        $res = $this->table->get($_POST['ref_id'], $_POST['ref_name'], $_POST['last'], $_POST['limit']);
        $this->view->setStatus($res !== false);
        $this->view->addData(["comments" => $res]);
    }

}
