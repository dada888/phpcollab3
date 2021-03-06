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
class idProjectComponents extends phpCollabComponents
{
  public function executeSidebar()
  {
    if($this->isRequestFieldEmpty('id'))
    {
      return sfView::NONE;
    }

    $this->project = $this->retrieveProject('id');
    $this->project_report = $this->retrieveProjectReport($this->project);
  }

  public function executeIndexSidebar()
  {
    $this->form = new ProjectFormFilter();
    if ($this->getRequest()->hasParameter('project_filters'))
    {
      $project_filters = $this->getRequest()->getParameter('project_filters');
      $this->form->bind($project_filters);
    }
  }
}
?>
