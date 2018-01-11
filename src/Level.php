<?php

namespace Level;

use Level\Config;
use Level\Helpers;
use Level\Page;

class Level {

	public $pages = array();
	public $query = array();
	public $request = array();
	
	/**
	 * Level App
	 * @param string $request The $_SERVER superglobal
	 * @param array $query The $_GET superglobal
	 */
	function __construct($request, $query)
	{
		//TODO use $query to support previewing from admin

		$this->query = $query;
		$this->request = $request;
	}
	
	/**
	 * Handle the submitted request
	 */
	function handleRequest() 
	{
		# Check pages cache
		//TODO write caching layer
		$pageOutput = '';

		# If page not in cache, build & cache
		if(Helpers::IsNullOrWhiteSpace($pageOutput))
		{
			# extract uri from request
			$requestUri = $this->uriFromRequest();

			# lookup page in $this->pages comparing $requestUri to $page->path
			$page = $this->lookupPage($requestUri, $this->buildPageTree(Helpers::JoinPaths([Config::$pagesFolder])));
			
			if(!$page) {								
				# Page doesn't exist
				throw new InvalidArgumentException('The page could not be found.');
			}	
			# Cache empty, render page
			$pageOutput = $page->render();
			
			# Write output to cache
			//TODO write caching layer
		}	

		echo $pageOutput;
	}

	/**
	 * Recursively builds site structure from pages folder (Config::$pagesFolder)
	 * @param string $dir The directory to parse
	 * @return array $pages Nested collection of Level\Page objects
	 */
	private function buildPageTree($dir)
	{
		$pages = array();
		$foldersAndFiles = Helpers::DirectoryContents($dir);
		
    # prevent empty ordered elements
    if (count($foldersAndFiles) > 0)
    {		
      foreach($foldersAndFiles as $folderOrFile)
      {        
        $absolutePath = Helpers::JoinPaths([$dir, $folderOrFile]);
        
        if(is_dir($absolutePath))
        {
					$page = new Page($absolutePath);

					array_push($pages, $page);
					
          $page->children = $this->buildPageTree($absolutePath);
        }
      }
		}
		
    return $pages;
	}

	/**
	 * Check for existance of page based on request uri
	 * @param string $requestUri The request uri
	 * @return string
	 */
	private function lookupPage($requestUri, $pages)
	{			
		$match = null;

		foreach($pages as $page){			
			# we have a match return
			if($requestUri == $page->path)
			{
				$match = $page;
			}

			# page has children, iterate
			if(is_null($match) && !empty($page->children))
			{
				$match = $this->lookupPage($requestUri, $page->children);
			}
		}

		return $match;
	}
	
	/** 
	 * Generates potential page directory from $_SERVER['REQUEST_URI']
	 * @return string
	 */
	private function uriFromRequest()   
	{    		
		return preg_replace(array('/^\//','/\/$/'), '', parse_url($this->request['REQUEST_URI'], PHP_URL_PATH));
	}
}