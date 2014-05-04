<?php

namespace Contact\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Contact extends Table {

    protected $_name = 'contact';
    protected $_primary = 'contact_id';

    public function __construct() {
        parent::__construct();
    }

}
