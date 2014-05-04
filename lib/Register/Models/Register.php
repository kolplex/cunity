<?php

namespace Register\Models;

use Core\Models\Db\Table\Users;
use Core\View\Message;

class Register {

    private $errors = [];

    public function __construct($action) {
        if (method_exists($this, $action))
            call_user_func([$this, $action]);
    }

    private function sendRegistration() {
        if (!$this->validateForm()) {
            $this->renderErrors();
        } else {
            $users = new Users();
            if ($users->registerNewUser($_POST)) {
                $view = new \Register\View\Registration();
                $view->assign('success', true);
                $view->render();
            }
        }
    }

    private function delete() {
        $config = \Core\Cunity::get("config");
        $functions = $config->registerFunctions->toArray();
        foreach ($functions["module"] AS $module)
            call_user_func([ucfirst($module) . "\Controller", "onUnregister"], $_SESSION['user']);
    }

    private function verify() {
        if (!isset($_GET['x']) || empty($_GET['x']))
            throw new Exception("No verify-code submitted!");
        $users = new Users();
        $user = $users->search("salt", $_GET['x']);
        if ($user !== NULL) {
            $user->groupid = 1;
            $user->save();
            $config = \Core\Cunity::get("config");
            $functions = $config->registerFunctions->toArray();
            foreach ($functions["module"] AS $module)
                call_user_func([ucfirst($module) . "\Controller", "onRegister"], $user);
            new Message("Ready to go!", "Your account was verified! You can now login!", "success");
        } else
            new Message("Sorry", "We cannot verify your account! The given data was not found!", "danger");
    }

    private function forgetPw() {
        if (!isset($_POST['resetPw'])) {
            $view = new \Register\View\ForgetPw();
            $view->render();
        } else {
            $users = new Users();
            $user = $users->search("email", $_POST['email']);
            if ($user !== NULL) {
                $token = rand(123123, 999999);
                $user->password_token = json_encode(["token" => $token, "time" => time()]);
                $user->save();
                new \Register\View\ForgetPwMail(["name" => $user->username, "email" => $user->email], $token);
                new Message("Done!", "Please check your mails! We have sent you a token to reset your password!", "success");
                exit();
            }
        }
        $view = new \Register\View\ForgetPw();
        $view->assign("error", true);
        $view->render();
    }

    private function reset() {
        $view = new \Register\View\ResetPassword();
        if (!empty($_POST)) {
            $users = new Users();
            $user = $users->search("email", $_POST['email']);
            if ($user !== NULL) {
                $tokendata = json_decode($user->password_token, true);
                if ($_POST['token'] == $tokendata['token']) {
                    if (time() - $tokendata["time"] > 1800) {
                        $this->errors["token"] = "The given token has expired! Every token is only valid for 30 minutes";
                    } else {
                        $validatePassword = new \Core\Models\Validation\Password();
                        if (!$validatePassword->passwordValid($_POST['password'], $_POST['password_repeat'])) {
                            $this->errors["password"] = implode(',', $validatePassword->getMessages());
                            $this->errors["password_repeat"] = "";
                        } else {
                            $user->password = sha1($_POST['password'] . $user->salt);
                            $user->password_token = NULL;
                            $user->save();
                            new Message("Done!", "Your password was changed successfully! You can now login!", "success");
                            exit();
                        }
                    }
                } else
                    $this->errors["token"] = "The given token is not correct!";
            } else
                $this->errors["email"] = "Email was not found in our system!";
            if (!empty($this->errors)) {
                foreach ($this->errors AS $error => $message)
                    if (!empty($message))
                        $error_messages[$error] = $view->translate($message);

                $view->assign("error_messages", $error_messages);
                $view->assign('success', false);
                $view->assign("values", $_POST);
            }
            $view->show();
        } else
            $view->show();
    }

    private function renderErrors() {
        $view = new \Register\View\Registration();
        $error_messages = [];
        if (!empty($this->errors)) {
            foreach ($this->errors AS $error => $message)
                if (!empty($message))
                    $error_messages[$error] = $view->translate($message);

            $view->assign("error_messages", $error_messages);
            $view->assign('success', false);
            $view->assign("values", $_POST);
        }
        $view->render();
    }

    private function validateForm() {
        $validateMail = new \Core\Models\Validation\Email();
        $validateUsername = new \Core\Models\Validation\Username();
        $validatePassword = new \Core\Models\Validation\Password();


        if (\Core\Cunity::get("settings")->getSetting("register_min_age")) {
            $validateBirthday = new \Core\Models\Validation\Birthday();
            if (!$validateBirthday->isValid($_POST['birthday']))
                $this->errors['birthday'] = implode(',', $validateBirthday->getMessages());
        }
        if (!$validateUsername->isValid($_POST['username']))
            $this->errors["username"] = $validateUsername->getMessages();
        if (!$validateMail->isValid($_POST['email']))
            $this->errors["email"] = implode(',', $validateMail->getMessages());
        if (!$validatePassword->passwordValid($_POST['password'], $_POST['password_repeat'])) {
            $this->errors["password"] = implode(',', $validatePassword->getMessages());
            $this->errors["password_repeat"] = "";
        }
        if (!isset($_POST['sex']) || ($_POST['sex'] != 'm' && $_POST['sex'] != "f"))
            $this->errors["sex"] = "Please select a gender";

        return empty($this->errors);
    }

}
