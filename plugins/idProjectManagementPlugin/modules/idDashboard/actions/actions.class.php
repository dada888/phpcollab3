<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idDashboardActions actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 */

/**
 * idDashboardActions actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idDashboardActions extends sfActions
{

  public function preExecute()
  {
    $project_ids = $this->getUser()->getMyProjectsIds();
    $this->recent_activities = Doctrine::getTable('EventLog')->retrieveEventsOfTheLastDaysByProjectsIds(3, $project_ids, 'LogDecorator');
  }

  protected function forwardToDashboard($user)
  {
    if ($user->isAdmin())
    {
      $this->forward('idDashboard', 'admin');
    }

    if ($user->isProjectManager())
    {
      $this->forward('idDashboard', 'projectManager');
    }

    if ($user->isCustomer())
    {
      $this->forward('idDashboard', 'customer');
    }

    if ($user->isDeveloper())
    {
      $this->forward('idDashboard', 'developer');
    }

    //forward to 404
  }

  /**
   * Shows to the user all the issues assigned to him.
   * The admin is forwarded to the list of the projects.
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forwardToDashboard($this->getUser());
  }

  public function executeAdmin(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->isAdmin(), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
  }

  public function executeCustomer(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->isCustomer(), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
  }

  public function executeDeveloper(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->isDeveloper(), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    
    $this->late_issues = $this->getUser()->retrieveMyLateIssues();
    $this->upcoming_issues = $this->getUser()->retrieveMyUpcomingIssues();
  }

  public function executeProjectManager(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->isProjectManager(), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
  }

}
