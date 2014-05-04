<?php

namespace Pages;

use Core\ModuleController;
use Pages\Models\Db\Table\Pages;

class Controller implements ModuleController {
    
    public function __construct(){
        $pages = new Pages();        
        $page = $pages->getPage($_GET['action']);
        if($page == NULL)
            new \Core\View\PageNotFound();
        $page->displayPage();
    }
    
    public static function onRegister($user) {
        
    }

    public static function onUnregister($user) {
        
    }

}
