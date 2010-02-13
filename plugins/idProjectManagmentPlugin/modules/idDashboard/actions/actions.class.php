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
  /**
   * Shows to the user all the issues assigned to him.
   * The admin is forwarded to the list of the projects.
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idDashboard-Read'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

    if ($this->getUser()->isAdmin())
    {
      $this->forward('idDashboard', 'admin');
    }
    
    $this->pager = new sfDoctrinePager('Issue',10);
    $this->pager->setQuery(Doctrine::getTable('Issue')->getQueryForUserIssues($this->getUser()->getProfile()->getId()));
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

    $this->projects = $this->getUser()->getProjectsIdsAndNamesWhereIhaveAssignedIssues();
  }

  public function executeAdmin()
  {
    
  }
}
