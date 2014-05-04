<?php

namespace Contact;

use Core\ModuleController;

class Controller implements ModuleController {

    public function __construct() {
        $this->handleRequest();
    }

    private function handleRequest() {        
        if (!isset($_GET['action'])||empty($_GET['action']))
            new View\ContactForm();
        else if (isset($_GET['action'])&& $_GET['action']=="sendContact")
            new Models\ContactForm();        
    }

    public static function onRegister($user) {
        
    }

    public static function onUnregister($user) {
        
    }

}


