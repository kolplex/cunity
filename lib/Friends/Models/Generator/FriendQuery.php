<?php

namespace Friends\Models\Generator;

class FriendQuery {

    public static function getFriendListQuery($status = "> 0") {
        return new \Zend_Db_Expr(\Core\Cunity::get("db")->select()
        ->from(\Core\Cunity::get("config")->db->params->table_prefix . "_relations", new \Zend_Db_Expr("(CASE WHEN sender = " . $_SESSION['user']->userid . " THEN receiver WHEN receiver = " . $_SESSION['user']->userid . " THEN sender END)"))
        ->where("status".$status)
        ->where("sender=? OR receiver=?", $_SESSION['user']->userid));
    }

}
