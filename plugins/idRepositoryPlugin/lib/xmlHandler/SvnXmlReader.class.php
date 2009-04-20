<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * SvnXmlReader
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * Reads the xml file produced by the call to svn log command
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 */


class SvnXmlReader {
	
  private $file_path;

  /**
   * Checks if the xml log file exists
   *
   * @return boolean
   */
  private function checkFileExists() {
		return is_file($this->file_path);
	}

  /**
   * Given a parsed xml file retrive and array of logData object and returns it.
   *
   * @param SimpleXMLElement $xml
   * @return array
   */
  private function returnLogDataArray(SimpleXMLElement $xml) {
    $logDataArray = array();
    foreach ($xml->logentry as $logentry) {
      $data = $this->getXmlLogDataFromLogEntry($logentry);
      $logDataArray["".$data->getLogRevisionNumber().""] = $data;
    }
    return $logDataArray;
  }

  /**
   * Convert a string representing a date into timestamp
   *
   * @param string $stringFromXml
   * @return string
   */
  private function getTimestamp($stringFromXml)
  {
    $array = explode('.', $stringFromXml);
    list($date, $time) = split('T',$array[0]);
    return strtotime($date." ".$time);
  }

  /**
   * Parse a xml log entry to fill a XmlLogData object
   *
   * @param SimpleXMLElement $logEntry
   * @return XmlLogData
   */
  private function getXmlLogDataFromLogEntry($logEntry) {
    $logData = new XmlLogData();
    $logData->setAuthor($logEntry->author);
    $logData->setDate($this->getTimestamp($logEntry->date[0]));
    $logData->setLogRevisionNumber($logEntry['revision'][0]);
    $logData->setMessage($logEntry->msg);
    if ($logEntry->paths)
    {
      foreach ($logEntry->paths->children() as $path) {
        $logData->setPath($path['action'], $path[0]);
      }
    }
    return $logData;
  }

  /**
   * Initialize the xml file path
   *
   * @param string $file_path
   */
	public function __construct($file_path) {
    $this->file_path = $file_path;
  }


  /**
   * Check if the xml log file existes and if it does, returns an array of XmlLogData objects
   *
   * @return array
   */
  public function readLog() {
    if(!$this->checkFileExists()){
			throw new Exception('Error: file '.$this->file_path." does not exist.");
		}
    $xml = simplexml_load_file($this->file_path, 'SimpleXMLElement');
		if (!$xml) {
			throw new Exception('Error: XML file is not valid.');
		}
    return $this->returnLogDataArray($xml);
	}

  /**
   * Return the xml log file path
   *
   * @return string
   */
	public function getFilePath(){
		return $this->file_path;
	}
}