<?php

namespace Admin\View;

use Core\View\View;

class Admin extends View {

    protected $templateDir = "";
    protected $templateFile = "";
    protected $wrapper = "Admin/out_wrap.tpl";

    public function __construct() {
        parent::__construct();
        \Admin\Models\Login::loginRequired();
        
        $this->show();
    }

}
