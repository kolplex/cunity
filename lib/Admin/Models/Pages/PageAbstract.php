<?php
namespace Admin\Models\Pages;

abstract class PageAbstract {
    
    protected $assignments = [];
    
    public function render($class){
        $class = "\\Admin\\View\\".ucfirst($class);
        $view = new $class;
        $view->assign($this->assignments);
        $view->show();
    }
}
