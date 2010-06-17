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
    $this->recent_activities = Doctrine::getTable('EventLog')->retrieveLastEventsByProjectIds(10, $project_ids, 'LogDecorator');
  }

  public function executeIndex(sfWebRequest $request)
  {
    if ($this->getUser()->isDeveloper())
    {
      $this->late_issues = $this->getUser()->retrieveMyLateIssues();
      $this->upcoming_issues = $this->getUser()->retrieveMyUpcomingIssues();
    }
  }
}
