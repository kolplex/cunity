<?php

namespace Register\Models;

use Core\Models\Db\Table\Users;

class Login {

    private $cunity = null;

    public function __construct($action = "") {
        if (method_exists($this, $action)) {
            call_user_func([$this, $action]);
        }
    }

    public function login() {
        if (!isset($_POST['email']) || !isset($_POST['password']))
            throw new \Core\Exception("Missing Parameters for login!");
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $users = new Users();
        $user = $users->search("email", $email);
        if ($user !== NULL) {
            if ($user->passwordMatch($password)) {
                if ($user->groupid == 0)
                    new \Core\View\Message("Sorry", "Your account is not verified! Please check your verification mail! if you have not received a mail, enter your email at \"I forgot my password\" and we will send you a new mail!", "danger");
                else if ($user->groupid == 2)
                    new \Core\View\Message("Sorry", "Your Account is blocked! Please contact the Administrator", "danger");
                else {
                    $user->setLogin(isset($_POST['save-login']));
                    header("Location:" . \Core\Models\Generator\Url::convertUrl("index.php?m=profile"));
                    exit();
                }
            } else
                new \Core\View\Message("Sorry", "The entered data is not correct!", "danger");
        } else
            new \Core\View\Message("Sorry", "The entered data is not correct!", "danger");
    }

    public static function checkAutoLogin($autologin = true) {
        if (!isset($_COOKIE['cunity-login']) || !isset($_COOKIE['cunity-login-token']))
            return false;
        $users = new \Core\Models\Db\Table\Users();
        $user = $users->search("username", base64_decode($_COOKIE['cunity-login']));
        if (md5($user->salt . "-" . $user->registered . "-" . $user->userhash) == $_COOKIE['cunity-login-token']) {
            if ($autologin) {
                $user->setLogin(true);
                header("Location:" . \Core\Models\Generator\Url::convertUrl("index.php?m=profile"));
                exit();
            } else
                return $user;
        }
        return false;
    }

    public function logout() {
        if (self::loggedIn()) {
            $_SESSION['user']->logout();
        }
        header("Location:" . \Core\Models\Generator\Url::convertUrl("index.php?m=start"));
        exit();
    }

    public static function loggedIn() {
        return (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true && isset($_SESSION['user']) && $_SESSION['user'] instanceof \Core\Models\Db\Row\User);
    }

    public static function loginRequired() {
        if (!self::loggedIn()) {
            $res = self::checkAutoLogin(false);
            if ($res !== false && $res instanceof \Core\Models\Db\Row\User) {
                $res->setLogin(true);
                header("Location:" . \Core\Models\Generator\Url::convertUrl("index.php?m=profile"));
            } else if (!isset($_GET['m']) || $_GET['m'] != "start") {
                if (!\Core\Models\Request::isAjaxRequest()) {
                    header("Location:" . \Core\Models\Generator\Url::convertUrl("index.php?m=start"));
                } else {
                    $view = new \Core\View\Ajax\View(false);
                    $view->addData(["session" => 0]);
                    $view->sendResponse();
                }
            }
        } else
            return;
        exit();
    }

}
