<?php

namespace Profile\Models;

use \Core\Models\Db\Row\User;

class Profile {

    protected $profileData = [];

    public function __construct() {
        if (\Core\Models\Request::isAjaxRequest())
            $this->handleAjaxAction();
        $this->checkUser();
        $this->render();
    }

    private function checkUser() {
        $users = $_SESSION['user']->getTable();
        if (isset($_GET['action']) && !empty($_GET['action'])) {
            $result = $users->get($_GET['action'], "username");
            if (!$result instanceof User || $result['name'] == NULL)
                new \Core\View\PageNotFound();
        } else
            $result = $users->get($_SESSION['user']->userid); // Get a new user Object with all image-data                
        $result = $result->toArray();
        //$result['privacy'] = \Core\Models\Generator\Privacy::parse($result['privacy']);
        $this->profileData = $result;
        if (isset($this->profileData['status']) && $this->profileData['status'] === 0 && $this->profileData['receiver'] == $_SESSION['user']->userid)
            new \Core\View\PageNotFound();
    }

    protected function render() {
        $view = new \Profile\View\Profile();
        $view->assign('profile', $this->profileData);
        $view->setMetaData(["title" => $this->profileData['name']]);
        $view->render();
    }

    private function handleAjaxAction() {
        switch ($_GET['action']) {
            case 'getpins':
                $pins = new Db\Table\ProfilePins();
                $result = $pins->getAllByUser($_POST['userid']);
                $view = new \Core\View\Ajax\View(true);
                if (!is_array($result)) {
                    $result = $result->toArray();
                    foreach ($result AS $i => $res)
                        $result[$i]['content'] = htmlspecialchars_decode($res['content']);
                } else
                    $result = [];
                $view->addData(["result" => $result]);
                $view->sendResponse();
                break;
        }
    }

}
