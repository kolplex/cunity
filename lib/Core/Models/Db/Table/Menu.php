<?php

namespace Core\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Menu extends Table {

    protected $_name = 'menu';
    protected $_primary = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function getMainMenu() {        
        $res = $this->fetchAll($this->select()->where("menu='main'"));
        return $res->toArray();
    }
    
    public function getFooterMenu() {        
        $res = $this->fetchAll($this->select()->where("menu='footer'"));
        return $res->toArray();
    }

}
