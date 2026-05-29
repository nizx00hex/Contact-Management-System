<?php

require_once 'config/Database.php';

spl_autoload_register(function($class) {    
    require_once 'models/' . $class . '.php';
});