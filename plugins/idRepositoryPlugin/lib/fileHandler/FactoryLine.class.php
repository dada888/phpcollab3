<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * FactoryLine
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * FactoryLine returns the right type of line base on an input string
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 */
class FactoryLine {

  const block = '@@';

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
   * @param string $line
   * @return unknown
   */
  public function build($line)
  {
    $type = substr($line, 0, 2);
    switch($type)
    {
      case  self::block:
        return new DiffBlockLine($line);
      default:
        return new DiffLine($line);
    }
  }
}
?>
