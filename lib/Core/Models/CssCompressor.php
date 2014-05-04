<?php

namespace Core\Models;

class CssCompressor {

    public static function compress($input) {
        // Remove comments
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

// Remove space after colons
        $buffer = str_replace(': ', ':', $buffer);

// Remove last semicolon before bracket
        $buffer = str_replace(';}', '}', $buffer);

        $buffer = str_replace('; ', ';', $buffer);

// Remove whitespace
        $buffer = str_replace(["\r\n", "\r", "\n", "\t", '  ', '    ', '    '], '', $buffer);
        return $buffer;
    }

}
