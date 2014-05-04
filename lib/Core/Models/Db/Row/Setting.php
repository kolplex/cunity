<?php

namespace Core\Models\Db\Row;


class Setting extends \Zend_Db_Table_Row_Abstract {
    
    public function init() {
        parent::init();
        array_walk($this->_data,[$this,"stringtotypes"]);
    }
    
    private function stringtotypes(&$val){
        $val = ($val===1 || $val === true || $val === 0 || $val === false) ? (boolean)$val : $val;            
    }
}
