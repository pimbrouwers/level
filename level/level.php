<?php

namespace Level;

require_once('config.php');
require_once('helpers.php');
require_once('page.php');

use Level\Config;
use Level\Helpers;
use Level\Page;

class Level {

  /**
   * Level App
   * @param array $request The $_GET superglobal
   */
  function __construct($request)
  {
    # Resolve page directory from $_GET
    $pageDir = $this->pageDirFromRequest($request);

    if(!$this->pageExists($pageDir)) {
      # Page doesn't exist
      Helpers::Http404();
    }

    $page = new Page($pageDir);
  }

  /** 
   * Generates potential page directory from $_GET['path']
   * @param array $request The $_GET superglobal
   * @return string
   */
  private function pageDirFromRequest($request)   
  {    
    # Homepage check
    if(!array_key_exists('path', $request)) $request['path'] = '/index';
    
    return Config::$pagesFolder . $request['path'];
  }

  /**
   * Check for existance of page directory
   * @param string $pageDir
   * @return bool 
   */
  private function pageExists($pageDir)
  {
    return is_dir($pageDir);
  }
}