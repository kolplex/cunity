<?php

namespace Core\Models\Generator;

class Privacy {

    private static $privacies = ["message" => 3, "visit" => 3, "posts" => 3, "search" => 3];

    public static function parse($privacyString) {
        if (!is_string($privacyString) || empty($privacyString) || $privacyString == null)
            return self::$privacies;
        $privacy = explode(',', $privacyString);
        $r = self::$privacies;
        foreach ($privacy AS $p) {
            $x = explode(':', $p);
            $r[$x[0]] = intval($x[1]);
        }
        return $r;
    }

}
