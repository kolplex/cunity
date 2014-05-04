<?php

namespace Core;

class Controller {

    private $cunity = null;

    public function __construct() {
        array_walk_recursive($_GET, [$this, 'trimhtml']);
        array_walk_recursive($_POST, [$this, 'trimhtml']);

        Cunity::init();

        session_name("cunity-" . Cunity::get("settings")->getSetting("filesdir")); //use the filesdir hash as unique session name        
        session_start();
        if (Models\Request::isAjaxRequest())
            set_exception_handler([$this, 'handleAjaxException']);
        else
            set_exception_handler([$this, 'handleException']);
        $this->handleQuery();
    }

    private function trimhtml(&$value) {
        $value = trim(htmlspecialchars($value, ENT_QUOTES));
    }

    static function handleException($e) {
        new \Core\View\Exception\View($e);
    }

    static function handleAjaxException($exception) {
        $view = new \Core\View\Ajax\View();
        $view->setStatus(false);
        $view->addData(["msg" => $exception->getMessage()]);
        $view->sendResponse();
    }

    protected function handleQuery() {
        if (!isset($_GET['m']) || empty($_GET['m'])) {
            if (\Register\Models\Login::loggedIn()) {
                header("Location:" . Models\Generator\Url::convertUrl("index.php?m=profile"));
                exit();
            } else
                $_GET['m'] = 'start';
        }
        $moduleController = new Module($_GET['m']);
        if (!\Core\Models\Request::isAjaxRequest() && !$moduleController->isActive())
            throw new Exception("The called module is turned off!");
        else if ($moduleController->isValid()) {
            $classname = $moduleController->getClassName();
            new $classname;
        } else
            throw new Exception("The called Module is not a valid Cunity-Module!");
    }

}
