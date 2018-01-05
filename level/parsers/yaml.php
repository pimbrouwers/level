<?php 

namespace Level;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class YamlParser {

  /** 
   * Parse the page YAML from the provided dir 
   * @param string $contentFilePath YAML file path
   * @return array $content Parsed YAML content
   */  
  function getContent($contentFilePath) 
  {
    try 
    {
      $content = Yaml::parseFile($contentFilePath);
    }
    catch (ParseException $e)
    {
      Helpers::Http500($e);
    }
    
    return $content;
  }
}