<?php

// Config file
require_once 'config/config.php';

// Autoload
spl_autoload_register('autoLoader');

function autoLoader($class)
{    
  if (class_exists($class, false)) {
    return true;
  }

  require_once 'libraries/' . $class . '.php';
}