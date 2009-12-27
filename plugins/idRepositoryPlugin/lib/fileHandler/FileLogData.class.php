<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * FileLogData
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * FileLogData class represents a log data entry.
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 */

class FileLogData implements LogData{

  private $logRevisionNumber;
  private $author;
  private $date;
  private $paths = array();
  private $message;

  /**
   * empty
   */
  public function __construct()
  {
  }

  /**
   * Returns the revision number that identifies the object
   *
   * @return mixed
   */
  public function getLogRevisionNumber()
  {
    return $this->logRevisionNumber;
  }

  /**
   * Returns the author of the log entry
   *
   * @return string
   */
  public function getAuthor()
  {
    return $this->author;
  }

  /**
   * Return the date of the log entry as timestamp
   *
   * @return timestamp
   */
  public function getDate()
  {
    return $this->date;
  }

  /**
   * Returns an array of string that represents the file modified/added/deleted
   *
   * @return array
   */
  public function getPaths()
  {
    return $this->paths;
  }

  /**
   * Return the message associated with the log entry
   *
   * @return string
   */
  public function getMessage()
  {
    return $this->message;
  }

  /**
   * Sets the log revision identifier
   *
   * @param mixed $revision_number
   */
  public function setLogRevisionNumber($revision_number)
  {
    $this->logRevisionNumber = $revision_number;
  }

  /**
   * Sets the author of the log entry
   *
   * @param string $author
   */
  public function setAuthor($author)
  {
    $this->author = $author;
  }

  /**
   * Sets the date of the log entry
   *
   * @param timestamp $date
   */
  public function setDate($date)
  {
    $this->date = $date;
  }

  /**
   * Sets the a path of a file that has been modified/deleted/added
   *
   * @param string $action
   * @param string $path
   */
  public function setPath($action, $path)
  {
    if(substr($path,0,1) == '/')
    {
      $path = preg_replace('/\//', '', $path, 1);
    }
    $this->paths[] = array('action' => $action, 'path' => $path);
  }

  /**
   * Sets tha messge of the log entry
   *
   * @param string $message
   */
  public function setMessage($message)
  {
    $this->message = $message;
  }

}