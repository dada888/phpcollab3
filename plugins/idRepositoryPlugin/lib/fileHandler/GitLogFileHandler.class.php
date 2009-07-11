<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * GitLogFileHandler
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * GitLogFileHandler class represents a log data entry.
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 * @author Francesco (cphp) Trucchia <ft@ideato.it>
 */

class GitLogFileHandler {

  private $file_path;
  private $separator;
  private $prefix;
  private $suffix;
  private $usedOptions;

  /**
   * Removes empty line from the array
   *
   * @param array $array
   */
  private function cleanUpNullElementArray($array)
  {
    $keys = array_keys($array, '');
    foreach ($keys as $key)
    {
      unset($array[$key]);
    }
  }

  /**
   * Reads the file created by git log command.
   * It creates an array of LogData object and returns it
   *
   * @return array
   */
  private function readLogFile()
  {
    $logDataArray = array();
    $resourceLogFile = fopen($this->file_path, 'r');
    $fileData = fread(
      $resourceLogFile,
      filesize($this->file_path));

    fclose($resourceLogFile);

    $logEntries = split($this->prefix, $fileData);

    $logEntryid = 0;
    foreach ($logEntries as $logEntry)
    {
      if($logEntryid == 0)
      {
        //TODO: find another way to represent the output from "git log" so that the first element will not be a null. (@see: gitLogFile in cache folder)
        $logEntryid++;
        continue;
      }

      $logDataObject = new FileLogData();
      
      $logDataCommitAndFile = explode($this->suffix, $logEntry);
      $commitDataArray = explode($this->separator,$logDataCommitAndFile[0]);

      $modifiedPathArray = array();
      if(isset($logDataCommitAndFile[1])){
        $modifiedPathArray = explode("\n", $logDataCommitAndFile[1]);
      }

      $this->cleanUpNullElementArray(&$modifiedPathArray);

      //TODO: relate the key set for git log in parameter "pretty format" to the moethods called here
      $logDataObject->setLogRevisionNumber($commitDataArray[0]);
      $logDataObject->setAuthor($commitDataArray[1]);
      $logDataObject->setDate($commitDataArray[2]);
      $logDataObject->setMessage($commitDataArray[3]);

      //Parsing modified paths
      foreach ($modifiedPathArray as $actionPath)
      {
        list($action, $path) = split("\t",$actionPath);
        $logDataObject->setPath($action, $path);
      }

      $logDataArray[$logDataObject->getLogRevisionNumber()] = $logDataObject;
      $logEntryid++;
    }

    return $logDataArray;
  }

  /**
   * Initializes the file path where is written the log command output.
   * Sets the value for sepratot, prefix and suffix to be used parsing the log file.
   *
   *
   * @param string $file_path
   * @param string $separator
   * @param string $prefix
   * @param string $suffix
   */
  function __construct($file_path, $separator, $prefix, $suffix)
  {
    if (!$file_path || !$separator)
    {
      throw new Exception('Git Repository Exception: file path and separator should be both not null.');
    }

    $this->file_path = $file_path;
    $this->separator = $separator;
    $this->prefix = $prefix;
    $this->suffix = $suffix;
  }

  /**
   * stores the option list used in the log command
   *
   * @param string $optionList
   */
  public function setUsedOptionsList($optionList)
  {
    $this->usedOptions = $optionList;
  }

  /**
   * returns the file path
   *
   * @return string
   */
  public function getFilePath()
  {
    return $this->file_path;
  }

  /**
   * returns the separator
   *
   * @return string
   */
  public function getSeparator()
  {
    return $this->separator;
  }

  /**
   * returns the prefix
   *
   * @return string
   */
  public function getPrefix()
  {
    return $this->prefix;
  }

  /**
   * returns the suffix
   *
   * @return suffix
   */
  public function getSuffix()
  {
    return $this->suffix;
  }

  /**
   * return an array of LogData objects
   *
   * @return array
   */
  public function getLog()
  {
    if (!file_exists($this->file_path))
    {
      throw new Exception('Git Repository Exception: log file does not exist ('.$this->file_path.').');
    }
    return $this->readLogFile();
  }
}