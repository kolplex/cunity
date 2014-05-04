<?php

namespace Events\Models\Db\Table;

use Core\Models\Db\Abstractables\Table;

class Guests extends Table {

    protected $_name = 'events_guests';

    public function __construct() {
        parent::__construct();
    }

    public function addGuests(array $guests) {
        $res = [];
        if (count($guests) > 0) {
            foreach ($guests AS $guest) {
                $res[] = $this->insert($guest);
            }
        }
        return !in_array(false, $res);
    }

    public function getGuests($eventid, $sort = true) {
        $guests = [];
        $res = $this->fetchAll($this->select()->where("eventid=?", $eventid));
        if ($res !== NULL) {
            if ($sort) {
                foreach ($res AS $guest) {
                    if ($guest->status == 0)
                        $guests['invited'][] = $guest;
                    else if ($guest->status == 1)
                        $guests['maybe'][] = $guest;
                    else if ($guest->status == 2)
                        $guests['attending'][] = $guest;
                }
                return $guests;
            }
            return $res;
        }
        return false;
    }

}
