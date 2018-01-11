<?php 

namespace Level\Parsers;

use \Symfony\Component\Yaml\Yaml;
use \Symfony\Component\Yaml\Exception\ParseException;

class YamlParser {

  /** 
   * Parse the page YAML from the provided dir 
   * @param string $contentFilePath YAML file path
   * @return array Parsed YAML content
   */  
  function getContent($contentFilePath) 
  {
    try 
    {
      return Yaml::parseFile($contentFilePath);
    }
    catch (ParseException $e)
    {
			throw $e;
		}
  }
}
