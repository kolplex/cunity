<?php

namespace Core\Models\Validation;

use Core\Models\Db\Table\Users;

class Username extends \Zend_Validate_Alnum {

    const USED = 'used';
    const LENGTH = 'length';
    const INVALID = 'invalid';

    protected $_messageTemplates = [
        self::USED => "This username is already in use",
        self::LENGTH => "The username-length should be between 2 and 20 characters!",
        self::INVALID => "The username contains not allowed characters!"
    ];

    public function isValid($value) {
        $this->_setValue($value);
        if (empty($value) || strlen($value) < 2 || strlen($value) > 20)
            $this->_error(self::LENGTH);
        else {
            $status = @preg_match('/^[A-Za-z0-9_.-]*$/', $value);
            if (false === $status || !$status) {
                $this->_error(self::INVALID);
                return false;
            }
            $users = new Users();
            $user = $users->search("username", $value);
            if ($user !== NULL && \Register\Models\Login::loggedIn() && $user->userid !== $_SESSION['user']->userid) {
                $this->_error(self::USED);
                return false;
            } else
                return parent::isValid($value);
        }
    }

}
