<?php

namespace Level;

class Config {

  static $devMode = true;

  static $rootFolder = './';
  static $levelFolder = './level';
	static $adminFolder = './level/admin';
	static $errorsFolder = './public/errors';
	static $pagesFolder = './pages';
	static $pagesCacheFolder = './cache/pages';
	static $templatesFolder = './templates';
  
  static $defaultTemplate = 'default.php';
}