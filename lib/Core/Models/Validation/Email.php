<?php

namespace Core\Models\Validation;

use Core\Models\Db\Table\Users;

class Email extends \Zend_Validate_EmailAddress {

    const USED = 'used';
    const EMPTYSTRING = 'empty';

    protected $_messageTemplates = [
        self::USED => "This E-Mail address is already in use",
        self::EMPTYSTRING => "Please enter an email!"
    ];

    public function isValid($value) {
        $this->_setValue($value);
        $users = new Users();
        if (empty($value))
            $this->_error(self::EMPTYSTRING);
        else {
            $user = $users->search("email", $value);
            if ($user !== NULL && \Register\Models\Login::loggedIn() && $user->userid !== $_SESSION['user']->userid) {
                $this->_error(self::USED);
                return false;
            } else
                return parent::isValid($value);
        }
    }

}
