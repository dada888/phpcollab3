<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idProjectComponents
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 */

/**
 * idProjectComponents class for components in idProject modules templates
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idProjectComponents extends sfComponents
{
  public function executeSidebar()
  {
  }

  public function executeShowSidebar()
  {
    $this->project = Doctrine::getTable('Project')->findOneById($this->getRequest()->getParameter('id'));
    $reports = Doctrine::getTable('Project')->getReportsOnProjectsWithEffortChart(array($this->project));

    if (isset($reports[$this->project->id]))
    {
      $this->project_report = $reports[$this->project->id];
    }
  }

  public function executeIndexSidebar()
  {
    $this->form = new ProjectFormFilter();
    if ($this->getRequest()->hasParameter('project_filters'))
    {
      $project_filters = $this->getRequest()->getParameter('project_filters');
      $this->form->bind($project_filters);
    }

    $project_ids = $this->getUser()->getMyProjectsIds();
    $logs = Doctrine::getTable('EventLog')->retrieveLastLoggedEventFromProjects($project_ids);
    $this->recent_events = LogDecorator::decorateCollectionToArray($logs);
  }
}
?>
