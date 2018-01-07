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
	 * @param string $request The $_SERVER superglobal
   * @param array $query The $_GET superglobal
   */
  function __construct($request, $query)
  {
		//TODO use $query to support previewing from admin

    # Resolve page directory from $_GET
    $this->pageDir = $this->pageDirFromRequest($request);
	}
	
	/**
	 * Render the requested page
	 */
	function renderPage() 
	{
		if(!$this->pageExists($this->pageDir)) {
      # Page doesn't exist
      Helpers::Http404();
		}	
		
		# Check pages cache 
		//TODO write caching layer

		# No page cache, create, cache and render
		$page = new Page($this->pageDir);
		$pageOutput = $page->render();

		echo $pageOutput;
	}

  /** 
   * Generates potential page directory from $_SERVER['REQUEST_URI']
   * @param array $request The $_SERVER superglobal
   * @return string
   */
  private function pageDirFromRequest($request)   
  {    		
		$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    # Homepage check
    if(strcmp($requestUri, '/') == 0) $requestUri = '/index';
    
    return Config::$pagesFolder . $requestUri;
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