<?php
namespace Core\Models\Generator;

class Unique {

    public static function createSalt($max = 25) {
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $i = 0;
        $salt = "";
        do {
            $salt .= $characterList{mt_rand(0, strlen($characterList) - 1)};
            $i++;
        } while ($i < $max);
        return $salt;
    }

}
