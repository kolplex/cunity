<?php

namespace Core\Models\Validation;

class Birthday extends \Zend_Validate_Abstract {

    const INVALID = 'invalid';
    const TOOYOUNG = 'tooyoung';

    protected $_messageTemplates = [
        self::INVALID => "Please enter a valid date!",
        self::TOOYOUNG => "You are too young to register! Minimum age is "
    ];

    public function __construct($options = []) {
        $this->_messageTemplates[self::TOOYOUNG] .= \Core\Cunity::get("settings")->getSetting("register_min_age");
    }

    public function isValid($value) {
        $this->_setValue($value);        
        if(!is_array($value) || empty($value['month']) || empty($value['day']) || empty($value['year']))
            $this->_error(self::INVALID);
        else if (!checkdate($value['month'], $value['day'], $value['year']))
            $this->_error(self::INVALID);
        else {
            $now = new \DateTime();
            $received = new \DateTime($value['year']."-".$value['month']."-".$value['day']);
            if ($received->diff($now)->y < \Core\Cunity::get("settings")->getSetting("register_min_age"))
                $this->_error(self::TOOYOUNG);
            else
                return true;
        }    
        return false;
    }

}
