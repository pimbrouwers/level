<?php 

/**
 * 
 * Level: Dead simple, database-less content management
 * 
 * Yaml parser wrapper leveraging symfony/yaml
 * 
 * PHP version 7
 * 
 * @author		Pim Brouwers
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link			https://github.com/pimbrouwers/level
 * 
 */

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
