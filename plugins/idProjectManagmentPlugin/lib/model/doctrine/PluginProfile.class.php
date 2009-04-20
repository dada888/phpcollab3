<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PluginProfile.class.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Model
 */


/**
 * This class represents the way to access to the users profiles.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Model
 */
abstract class PluginProfile extends BaseProfile
{
  /**
   * Returns the name of a user as [first_name] (username) [last_name] <email>
   *
   * @return string
   */
  public function getName()
  {
    $user = $this->getUser();
    return $this->getFirstName().' ('.$user->getUsername().') '.$this->getLastName().' <'.$this->getEmail().'>';
  }
  
}