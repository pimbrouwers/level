<?php

require_once('../vendor/autoload.php');

use Level\Config;
use Level\Helpers;
use Level\Level;
use Symfony\Component\Yaml\Exception\ParseException;

# Set error level
if(Config::$devMode) {
  error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
}
else {
  error_reporting(0);
}

# Start app
$app = new Level($_SERVER, $_GET);

# Process request
try
{
	$app->handleRequest();
}
catch (InvalidArgumentException $e)
{
	Helpers::Http404();
}
catch (ParseException $e)
{
	Helpers::Http500($e);
}
