<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * LogCommandFactory
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * Factory to create right log command
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 * @author Francesco (cphp) Trucchia <ft@ideato.it>
 */


class LogCommandFactory 
{
  static private $instance = null;

  /**
   * initalize the factory class
   *
   * @return LogCommandFactory
   */
  public static function init()
  {
    $class = __CLASS__;
    return self::$instance = new $class;
  }
  
  /**
   * Return an instance of this class
   *
   * @return LogCommandFactory
   */
  public static function getInstance()
  {
    return self::$instance;
  }
  
  /**
   * Build right LogCommand
   *
   * @param unknown_type $classkey
   * @return unknown
   */
  public function build($type)
  {
    switch($type)
    {
      case  RepositoryFactory::git:
        return new GitLogCommand();
      case  RepositoryFactory::svn:
        return new SvnLogCommand();
    }
  }
}