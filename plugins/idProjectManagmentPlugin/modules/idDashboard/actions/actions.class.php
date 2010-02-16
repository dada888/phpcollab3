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
 * @subpackage idProjectManagmentPlugin Modules
 */

/**
 * idDashboardActions actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Modules
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idDashboardActions extends sfActions
{

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

    $this->pager = new sfDoctrinePager('Issue',10);
    $this->pager->setQuery(Doctrine::getTable('Issue')->getQueryForUserIssues($this->getUser()->getProfile()->getId()));
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

    $this->projects = $this->getUser()->getProjectsIdsAndNamesWhereIhaveAssignedIssues();
  }

  public function executeProjectManager(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->isProjectManager(), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
  }

}
