<?php

namespace Core\View\Ajax;

class View extends \Core\View\View {

    private $status = true;
    private $_values = [];
    
    public function __construct($status=false){
        $this->setStatus($status);
    }
    

    public function setStatus($status) {
        $this->status = ($status === true);
    }

    public function addData(array $values) {        
        $this->_values = $values;
    }
    
    public function sendResponse(){
        header('Content-type: application/json');
        header("Cache-Control: no-cache, must-revalidate"); // Disable Cache
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        exit(json_encode(array_merge(["status" => $this->status], $this->_values)));
    }

}


