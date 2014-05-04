<?php

namespace Events\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Events extends Table {

    protected $_name = 'events';
    protected $_primary = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function addEvent(array $data) {
        return $this->insert($data);
    }

    public function deleteEvent($eventid) {
        return (0 < $this->delete($this->getAdapter() > quoteInto("id=?", $eventid)));
    }

    public function getEventData($eventid) {
        $res = $this->find($eventid);
        if ($res !== NULL)
            return $res->current()->toArray();
    }

    public function fetchBetween($start, $end) {
        $query = $this->getAdapter()->select()->from(["e" => $this->dbprefix . "events"], ["*", new \Zend_Db_Expr("UNIX_TIMESTAMP(start)*1000 AS start"), new \Zend_Db_Expr("UNIX_TIMESTAMP(DATE_ADD(start,INTERVAL +1 HOUR))*1000 AS end")])
                ->joinLeft(["g" => $this->dbprefix . "events_guests"], "g.eventid=e.id AND g.userid=" . $this->getAdapter()->quote($_SESSION['user']->userid), ["guestid", "status"])
                ->joinLeft(["u" => $this->dbprefix . "users"], "e.userid = u.userid", ["username", "name"])
                ->joinLeft(["pi" => $this->dbprefix . "gallery_images"], "pi.id = u.profileImage AND e.type = 'birthday'", "filename AS pimg")
                ->where("e.start BETWEEN " . $this->getAdapter()->quote($start) . " AND " . $this->getAdapter()->quote($end))
                ->where("e.type = 'event' OR (e.type = 'birthday' AND e.userid IN (" . \Friends\Models\Generator\FriendQuery::getFriendListQuery("=2") . "))")
                ->where("(g.guestid IS NULL AND e.type = 'birthday') OR (g.guestid IS NOT NULL AND e.type = 'event')");
        return $this->getAdapter()->fetchAll($query);
    }

}
