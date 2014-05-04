<?php

namespace Core;

interface ModuleController {
    
    public static function onRegister($user);
    
    public static function onUnregister($user);            
}
