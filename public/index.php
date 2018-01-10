<?php

require_once('../vendor/autoload.php');
require_once('../level/config.php');
require_once('../level/level.php');

use Level\Level;
use Level\Config;

# Set error level
if(Config::$devMode) {
  error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
}
else {
  error_reporting(0);
}

# Start app and process request
$app = new Level($_SERVER, $_GET);
$app->handleRequest();
