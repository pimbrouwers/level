<?php

/**
 * 
 * Level: Dead simple, database-less content management
 * 
 * Global variable config
 * 
 * PHP version 7
 * 
 * @author		Pim Brouwers
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link			https://github.com/pimbrouwers/level
 * 
 */

namespace Level;

class Config {

  static $devMode = true;

	static $errorsFolder = './errors';
	static $pagesFolder = '../pages';
	static $cacheFolder = '../cache';
	static $templatesFolder = '../templates';
  
	static $defaultTemplate = 'index.php';
		
}