<?php

/*
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


/**
 * myUser.class.php
 *
 * @package    phpCollab3
 */

/**
 * myUser class that extends sfGuardSecurityUser
 *
 * @package    phpCollab3
 * @author Filippo (p16) de Santis <fd@ideato.it>
 */

class myUser extends sfGuardSecurityUser
{
  /**
   * Retunrns all the projects stored into the aopplication
   *
   * @access private
   * @return boolean
   */
  private function getAdminProject()
  {
    $q = Doctrine_Query::create()
      ->from('Project')
      ->orderBy('created_at ASC');
    return $q->execute();
  }

  /**
   * Returns true if the actual user is a memeber of a project
   *
   * @access private
   * @param int $project_id
   * @return boolean
   */
  private function isMemberOfProject($project_id)
  {
    foreach ($this->getGuardUser()->Profile->projects as $project)
    {
      if ($project->getId() == $project_id)
      {
        return true;
      }
    }

    return false;
  }

  /**
   * Returns true iof the actual user is an admin
   *
   * @return <type>
   */
  public function isAdmin()
  {
    return ($this->isSuperAdmin() || $this->hasPermission('admin')) ? true : false;
  }

  /**
   * Retunrs the projects where the actual user is set as a member
   *
   * @param Doctrine_Query $query
   * @return array
   */
  public function getMyProjects($query = null)
  {
    if (!is_null($query))
    {
      return $query->execute();
    }
    
    if ($this->isAdmin())
    {
      return $this->getAdminProject();
    }

    $sf_guard_user = $this->getGuardUser();
    return $sf_guard_user->Profile->projects;
  }

  /**
   * Create the query for retriving the projects of a user.
   *
   * @return Doctrine_Query
   */
  public function getQueryForMyProjects()
  {
    $q = Doctrine_Query::create()
      ->from('Project p')
      ->orderBy('created_at ASC');

    if (!$this->isAdmin())
    {
      $q->addWhere('p.id IN (SELECT pu.project_id FROM ProjectUser pu WHERE pu.profile_id = ?)', $this->getGuardUser()->Profile->id);
    }
    
    return $q;
  }

  /**
   * Returns true if the actual user is a member of the given project
   *
   * @param int $project_id
   * @return boolean
   */
  public function isMyProject($project_id)
  {
    return $this->isAdmin() ? true : $this->isMemberOfProject($project_id);
  }

}
