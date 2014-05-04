<?php
namespace Core\Models\Generator;

class Url {
    
    public static function convertUrl($urlString) {                
        if (\Core\Cunity::get("mod_rewrite")) { //if mod rewrite is enabled!
            $parsedUrl = parse_url($urlString);
            parse_str($parsedUrl['query'], $parsedQuery);                        
            return  \Core\Cunity::get("settings")->getSetting("siteurl").implode('/', $parsedQuery);
        } else
            return \Core\Cunity::get("settings")->getSetting("siteurl").$urlString;
    }    
}
