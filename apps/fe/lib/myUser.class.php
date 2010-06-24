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
  private function getAdminProjects()
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

  public function isProjectManager()
  {
    return $this->hasCredential('project manager');
  }

  public function isCustomer()
  {
    return $this->hasCredential('customer');
  }

  public function isDeveloper()
  {
    return $this->hasCredential('user');
  }

  /**
   * TODO
   *
   * @param integer $project_id
   * @return boolean
   */
  public function canEditProject($project_id)
  {
    return $this->isAdmin();
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
      return $this->getAdminProjects();
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

  /**
   * Returns true if the actual user is a member of the given project
   *
   * @param int $project_id
   * @return boolean
   */
  public function isMyProjectByIssue($issue)
  {
    if (! ($issue instanceof Issue))
    {
      return false;
    }
    
    return $this->isAdmin() ? true : $this->isMemberOfProject($issue->getProject()->getId());
  }

  public function getMyProjectsIds()
  {
    $projects = ($this->isAdmin()) ? $this->getAdminProjects() : $this->getMyProjects();

    $ids = array();
    foreach ($projects as $project)
    {
      $ids[] = $project->id;
    }
    return $ids;
  }

  /**
   * Returns projects ids and names where the user have assigned issues
   *
   * @return array
   */
  public function getProjectsIdsAndNamesWhereIhaveAssignedIssues()
  {
    return Doctrine::getTable('Project')
            ->getQueryToRetrieveProjectWhereUserHaveAssignedIssues($this->getProfile()->getId())
            ->select('p.name as name, p.id as id')
            ->groupBy('p.name AND p.id')
            ->execute(array(), Doctrine::HYDRATE_ARRAY);
  }

  /**
   * Returns true if the id is the same as the user
   *
   * @param int $project_id
   * @return boolean
   */
  public function isMyProfile($id)
  {
    return $this->isAdmin() ? true : ($id == $this->getGuardUser()->getId());
  }

  public function retrieveNumberOfMyOpenIssueByProject($project_id)
  {
    $query = Doctrine::getTable('Issue')->getQueryForUserIssues($this->getProfile()->getId());
    return $query->
              addWhere('(s.status_type = ? OR s.status_type = ? )', array('new', 'assigned'))->
              addWhere('(i.project_id = ?)', array($project_id))->
              count();
  }

  public function retrieveMyClosedIssueByProject($project_id)
  {
    $query = Doctrine::getTable('Issue')->getQueryForUserIssues($this->getProfile()->getId());
    return $query->
              addWhere('(s.status_type = ? OR s.status_type = ? )', array('closed', 'invalid'))->
              addWhere('(i.project_id = ?)', array($project_id))->
              count();
  }

  public function retrieveMyLateIssues()
  {
    return Doctrine::getTable('Issue')->getLateIssuesForUserByProfileId($this->getProfile()->getId());
  }

  public function retrieveMyUpcomingIssues($days = 7)
  {
    return Doctrine::getTable('Issue')->getUpcomingIssuesForUserByProfileId($this->getProfile()->getId(), $days);
  }

  public function canSeeBudget()
  {
    return ($this->isAdmin() || !$this->isDeveloper());
  }

  public function canAddUsersToProject()
  {
    return ($this->isAdmin() || $this->hasPermission('CanAddUserToProject'));
  }

  public function retrieveMyIssuesForProject($project_id)
  {
    return Doctrine::getTable('Issue')->retrieveIssuesAssignedToUserByProject($this->getGuardUser()->Profile->id, $project_id);
  }

  public function countMyIssuesForProject($project_id)
  {
    return Doctrine::getTable('Issue')->countIssuesAssignedToUserByProject($this->getGuardUser()->Profile->id, $project_id);
  }

}
