<?php

namespace Level;

require_once('config.php');
require_once('helpers.php');
require_once('parsers/yaml.php');

use Level\Config;
use Level\Helpers;
use Level\YamlParser;

class Page {

  /**
   * Page object
   * @param string $dir The directory containing the page data
   */
  function __construct($dir)
  {
    # Parse YAML
    $parser = new YamlParser();
    $content = $parser->getContent($this->contentFilePath($dir));    

    # Determine template from YAML
    $template = $this->getTemplate($content);

    # Render the template
    echo $this->render($template, $content);
  } 

  /**
   * Render the page using the specified template
   * @param array $content Parsed YAML content
   * @return string $template Rendered template
   */
  function render($template, $content)
  {    
    $templatePath = Config::$templatesFolder . DIRECTORY_SEPARATOR . $template;
    
    if(!file_exists($templatePath))
    {
      Helpers::Http500(new Exception('Template ' . $templatePath . ' not found.'));
    }

    extract($content);

    ob_start();
    include_once($templatePath);
    $template = ob_get_contents();
    ob_end_clean();

    return $template;
  }

  /**
   * Resolve page content file based on provided dir 
   * @param string $dir Directory containing the page date
   * @return string $filePath YAML relative file path
   */
  private function contentFilePath($dir)
  {
    $filePathWithoutExtension = $dir . '/page';
    $filePath = $filePathWithoutExtension . '.yml';
    
    if(!file_exists($filePath))
    {   
      $filePath = $filePathWithoutExtension . '.txt';
      
      if(!file_exists($filePath))
      {
        # No page.yml or page.txt found, throw 404
        Helpers::Http404();
      }    
    }

    return $filePath;
  }

  /** 
   * Sets the page template 
   * @param array $content Parsed YAML content
   * @return string $template Template php filename
   */
  private function getTemplate($content)
  {
    $template = Config::$defaultTemplate;

    if(array_key_exists('template', $content))
    {
      $template = $content['template'];      
    }

    return $template;
  }
}