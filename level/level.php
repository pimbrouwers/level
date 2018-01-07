<?php

namespace Level;

require_once('config.php');
require_once('helpers.php');
require_once('page.php');

use Level\Config;
use Level\Helpers;
use Level\Page;

class Level {

	public $pageDir = '';

  /**
   * Level App
   * @param array $request The $_GET superglobal
   */
  function __construct($request)
  {
    # Resolve page directory from $_GET
    $this->pageDir = $this->pageDirFromRequest($request);

    if(!$this->pageExists($this->pageDir)) {
      # Page doesn't exist
      Helpers::Http404();
    }	
	}
	
	/**
	 * Render the requested page
	 */
	function renderPage() 
	{
		# Check pages cache 
		//TODO write caching layer

		# No page cache, create, cache and render
		$page = new Page($this->pageDir);
		$pageOutput = $page->render();

		echo $pageOutput;
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