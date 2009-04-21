<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * RepositoryFactory
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * Repository Factory
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 * @author Francesco (cphp) Trucchia <ft@ideato.it>
 */

class RepositoryFactory
{
  const svn = 'svn';
  const git = 'git';
  
  static private $instance = null;

  /**
   * initalize the factory class
   *
   * @return RepositoryFactory
   */
  public static function init()
  {
    $class = __CLASS__;
    return self::$instance = new $class;
  }
  
  /**
   * Return an instance of this class
   *
   * @return RepositoryFactory
   */
  public static function getInstance()
  {
    return self::$instance;
  }
  
  /**
   * Build right Repository
   *
   * @param unknown_type $classkey
   * @return unknown
   */
  public function build($type, $params)
  {
    switch($type)
    {
      case  self::git:
        return new GitRepository($params['local_repository'], new GitLogFileHandler($params['local_log_file'], $params['separator'], $params['prefix'], $params['suffix']));
      case  self::svn:
        return new SvnRepository(new SvnProxy($params['url']), new SvnXmlReader($params['xml']));
    }
  }
}