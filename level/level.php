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
	function handleRequest() 
	{
		if(!$this->pageExists($this->pageDir)) {
      # Page doesn't exist
      Helpers::Http404();
		}	

		# Check pages cache
		$pageOutput = $this->loadPageFromCache();

		if(Helpers::IsNullOrWhiteSpace($pageOutput))
		{
			# Cache empty, render
			$pageOutput = $this->renderPage();

			if(Helpers::IsNullOrWhiteSpace($pageOutput))
			{
				# Cache result, if exists
				$this->cachePage($pageOutput);
			}
		}	

		echo $pageOutput;
	}

	/**
	 * Insert the page into cache
	 * @param string $pageOutput The rendered HTML
	 */
	private function cachePage($pageOutput)
	{
		//TODO write page cacher
	}

	/**
	 * Load page from cache, if possible
	 * @return string $pageOutput The rendered HTML
	 */
	private function loadPageFromCache()
	{
		//TODO write caching layer
		return '';
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
	
	/**
	 * The physical output buffering of the request page
	 */
	private function renderPage()
	{		
		# No page cache, create, cache and render
		$page = new Page($this->pageDir);
		$pageOutput = $page->render();

		return $pageOutput;
	}
}