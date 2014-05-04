<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Models\Db\Rowset;

/**
 * Description of Rowset
 *
 * @author Julian
 */
class Rowset extends \Zend_Db_Table_Rowset_Abstract {

    //put your code here

    public function toSelectedArray(array $fields) {
        if (empty($this->_rows) && !empty($this->_data)) {
            foreach ($this->_data AS $i => $row) {
                $result = [];
                foreach ($fields AS $v)
                    $result[$v] = $this->_data[$i][$v];
                $this->_data[$i] = $result;
            }
        } else {
            foreach ($this->_rows AS $i => $row)
                $this->_data[$i] = $row->toSelectedArray($fields);
        }
        return $this->_data;
    }

}
