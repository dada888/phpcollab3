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
class idMessageComponents extends sfComponents
{
  public function executeSidebar()
  {
    $this->project = Doctrine::getTable('Project')->findOneById($this->getRequest()->getParameter('project_id'));
    $reports = Doctrine::getTable('Project')->getReportsOnProjectsWithEffortChart(array($this->project));

    if (!isset($reports[$this->project->id]))
    {
      return sfView::NONE;
    }
    
    $this->project_report = $reports[$this->project->id];
  }
}
?>
