<?php

/**
 * On-the-fly CSS Compression
 * Copyright (c) 2009 and onwards, Manas Tungare.
 * Creative Commons Attribution, Share-Alike.
 */
$cssFiles = explode(",", base64_decode($_GET['files']));

file_put_contents("css.txt",implode("--",$cssFiles));

$buffer = "";
foreach ($cssFiles as $cssFile)
    $buffer .= file_get_contents("../modules/" . $cssFile . ".css");


//$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

// Remove whitespace
$buffer = str_replace(["\r\n", "\r", "\n", "\t", '  ', '    ', '    '], '', $buffer);

$buffer = str_replace(': ', ':', $buffer);

$buffer = str_replace('; ', ';', $buffer);

$buffer = str_replace(';}', '}', $buffer);

$buffer = str_replace(' {', '{', $buffer);

// Enable GZip encoding.
ob_start("ob_gzhandler");

// Enable caching
header('Cache-Control: no-cache');

// Expire in one day
header('Expires: ' . gmdate('D, d M Y H:i:s', time() - 86400) . ' GMT');

// Set the correct MIME type, because Apache won't set it for us
header("Content-type: text/css");

// Write everything out
print $buffer;
