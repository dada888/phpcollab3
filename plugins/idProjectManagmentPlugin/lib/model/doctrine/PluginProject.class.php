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
 * Represents the way to access to project informations.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Model
 */
abstract class PluginProject extends BaseProject
{
  /**
   * Returns the list of members of a projects as array
   *
   * @return array of sfGuardUser objects or an empty array.
   */
  public function getProjectUsers()
  {
    $users = array();
    foreach ($this->getusers() as $profile)
    {
      $users[] = $profile->getUser();
    }

    return $users;
  }
}