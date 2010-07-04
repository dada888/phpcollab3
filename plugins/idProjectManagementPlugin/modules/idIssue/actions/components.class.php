<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * sfGuardUser/components.class.php
 *
 * @package    phpCollab3
 */

/**
 * idDashboardComponents components
 */
class idIssueComponents extends sfComponents
{
  public function executeSidebar()
  {
    $this->project = Doctrine::getTable('Project')->findOneBy('id', $this->getRequestParameter('project_id'));
    $reports = Doctrine::getTable('Project')->getReportsOnProjectsWithEffortChart(array($this->project));
    
    $this->project_report = (count($reports) > 0) ? $reports[$this->project->id] : null;
  }

  public function executeShowSidebar()
  {
    $this->issue = Doctrine::getTable('Issue')->getIssueById($this->getRequest()->getParameter('issue_id'));
  }
}
?>
