<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PluginProject.class.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Model
 */


/**
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    phpCollab3
 * @author Filippo (p16) De Santis <fd@ideato.it>
 * @subpackage idProjectManagmentPlugin Model
 */
abstract class PluginProject extends BaseProject
{
  /**
   * Checks if the projects has at least one milestone.
   *
   * @return boolean
   */
  public function hasRoadmap()
  {
    return count($this->Milestones) > 0;
  }
}