<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * XmlLogData
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


class XmlLogData implements LogData{

  private $logRevisionNumber;
  private $author;
  private $date;
  private $paths = array();
  private $message;

  /**
   * Return the log revision number
   *
   * @return mixed
   */
  public function getLogRevisionNumber() {
    return $this->logRevisionNumber;
  }

  /**
   * Return the revision author's name
   *
   * @return string
   */
  public function getAuthor() {
    return $this->author;
  }

  /**
   * Return the date of the revision
   *
   * @return string
   */
  public function getDate() {
    return $this->date;
  }

  /**
   * Returns an array of string representing the files paths modified
   *
   * @return array
   */
  public function getPaths() {
    return $this->paths;
  }

  /**
   * Returns the message associated with the revision
   *
   * @return string
   */
  public function getMessage() {
    return $this->message;
  }

  /**
   * Sets the revision number
   *
   * @param mixed $revision_number
   */
  public function setLogRevisionNumber($revision_number) {
    $this->logRevisionNumber = $revision_number;
  }

  /**
   * Sets the author name
   *
   * @param string $author
   */
  public function setAuthor($author) {
    $this->author = $author;
  }

  /**
   * Sets the date of the revision
   *
   * @param mixed $date
   */
  public function setDate($date) {
    $this->date = $date;
  }

  /**
   * Sets one file path and the action performed on it
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

  public function setMessage($message) {
    $this->message = $message;
  }

}