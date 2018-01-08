<?php

namespace Level;

require_once('config.php');

use Level\Config;

class Helpers {

	/**
	 * Checks for the absolute existence of a string value
	 * @param string $str The string to validate
	 * @return bool 
	 */
	function IsNullOrWhiteSpace($str){
			return (!isset($str) || trim($str)==='');
	}

  /**
   * Renders the 404 page 
   */
  static function Http404() {
    self::HttpResponse(404);
  }

  /**
   * Renders the 500 page including the exception if Config::$devMode == true
   * @param exception $exception The exception being thrown
   */
  static function Http500($exception) {
    if(Config::$dev_mode){
      echo $exception->getMessage();
    }

    self::HttpResponse(500);
  }

  /**
   * Internal function to set response code and include error page
   * @param int $code The http code
   */
  private static function HttpResponse($code)
  {
    http_response_code($code);
    include_once(Config::$errorsFolder . '/' . $code . '.php');
    exit;
  }
}