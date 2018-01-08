<?php

namespace Level;

require_once('config.php');
require_once('helpers.php');
require_once('parsers/yaml.php');

use Level\Config;
use Level\Helpers;
use Level\YamlParser;

class Page {

	public $children = array();
	public $contentType = '';
	public $dir = '';
	public $name = '';
	public $path = '';
	public $template = '';
	
	/**
	 * Page object
	 * @param string $dir The absolute directory containing the page data
	 */
	function __construct($dir)
	{		
		$this->dir = $dir;		
		$this->path = $this->pagePath($dir);
		$this->name = $this->pageName();
		$this->template = $this->resolveTemplate();
	} 

	/**
	 * Render the page using the specified template
	 * @return string $output Rendered template
	 */
	function render()
	{    
		# Parse content
		$pageContent = $this->pageContent();

		# Determine content type from template
		//TODO resolve content type from template extension

		# extract page key/value's
		if(is_array($pageContent))
		{
			extract($pageContent);
		}	

		# buffer the page
		ob_start();
		include_once($this->template);				
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	/**
	 * Resolve page content file based on provided dir 
	 * @return string $filePath YAML relative file path
	 */
	private function contentFilePath()
	{
		$filePath = '';		
		$foldersAndFiles = Helpers::DirectoryContents($this->dir);
		
		foreach($foldersAndFiles as $folderOrFile)
		{
			if(!is_dir($folderOrFile))
			{
				$pathinfo = pathinfo($folderOrFile);

				if($pathinfo['extension'] == 'yml')
				{
					$filePath = $this->dir . '/' . $folderOrFile;
					break;
				}
			}
		}
		
		return $filePath;
	}

	/**
	 * Get page content from yaml
	 * @return array
	 */
	private function pageContent(){
		# Parse YAML
		$parser = new YamlParser();
		return $parser->getContent($this->contentFilePath($this->dir));    
	}

	/**
	 * Get the name from the path
	 * @return string
	 */
	private function pageName()
	{
		return basename($this->path);
	}

	/**
	 * Get the page path from the page dir
	 * @param string $dir The page dir
	 * @return string
	 */
	private function pagePath($dir)
	{
		return preg_replace(array('/\d\./', '/^\.\/pages\//', '/index$/'), '', $dir);
	}

	/**
	 * Resolve page template file path
	 * @return string $templatePath PHP template path
	 */
	private function resolveTemplate()
	{		
		$templatePath = Config::$templatesFolder . '/' . $this->name . '.php';

		if(!file_exists($templatePath))
		{
			# default template to config value
			$templatePath = Config::$templatesFolder . '/' . Config::$defaultTemplate;
		}

		return $templatePath;		
	}
}