<?php

namespace Core\Models\Validation;

class Password extends \Zend_Validate_StringLength {

    protected $_min = 6;
    protected $_max = 30;

    const LENGTH = 'length';
    const EMPTYSTRING = 'empty';
    const MATCH = 'match';

    protected $_messageTemplates = [
        self::EMPTYSTRING => "Please enter a password",
        self::LENGTH => "The Password-Length should be between 6 and 30 characters!",
        self::MATCH => "Your entered passwords do not match"
    ];

    public function passwordValid($password, $passwordRepeat) {
        if ($password == "") {
            $this->_error(self::EMPTYSTRING);
            return false;
        }if (strlen($password) < $this->_min || strlen($password) > $this->_max) {
            $this->_error(self::LENGTH);
            return false;
        } else if ($password !== $passwordRepeat) {
            $this->_error(self::MATCH);
            return false;
        } else
            return parent::isValid($password);
    }

}


