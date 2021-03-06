<?php

/**
 * 
 * Level: Dead simple, database-less content management
 * 
 * Global helper functions
 * 
 * PHP version 7
 * 
 * @author		Pim Brouwers
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link			https://github.com/pimbrouwers/level
 * 
 */

namespace Level;

use Level\Config;

class Helpers {

  /**
   * Returns the contents of a directory, ignoring . & .. entries
   * @param string $dir
   * @return array 
   */
  static function DirectoryContents($dir)
  {
    return array_slice(scandir($dir), 2);
  }

	/**
	 * Checks for the absolute existence of a string value
	 * @param string $str The string to validate
	 * @return bool 
	 */
	static function IsNullOrWhiteSpace($str){
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
    if(Config::$devMode){
      echo $exception->getMessage();
    }

    self::HttpResponse(500);
	}
	
	/**
	 * Joins string[] of path parts into os safe paths
	 * @param array $paths Pieces to join
	 * @return string OS safe path
	 */
	static function JoinPaths ($paths)
	{
		return preg_replace('#/+#',DIRECTORY_SEPARATOR, join(DIRECTORY_SEPARATOR, $paths));
	}

  static function PrettyPrint($obj)
  {
    echo '<pre>';
    print_r($obj);
    echo '</pre>';
  }

  /**
   * Internal function to set response code and include error page
   * @param int $code The http code
   */
  private static function HttpResponse($code)
  {
		http_response_code($code);
    include_once(Helpers::JoinPaths([Config::$errorsFolder, $code . '.php']));
    exit;
  }

}