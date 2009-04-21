<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * LogData
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * Interface data object filled with the results from the log commans on repository
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 */

interface LogData {

  public function getLogRevisionNumber();

  public function getAuthor();

  public function getDate();

  public function getPaths();

  public function getMessage();

  public function setLogRevisionNumber($revision_number);

  public function setAuthor($author);

  public function setDate($date);

  public function setPath($action, $path);

  public function setMessage($message);
  
}