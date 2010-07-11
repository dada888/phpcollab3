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
class idIssueComponents extends phpCollabComponents
{
  public function executeSidebar()
  {
    if($this->isRequestFieldEmpty('project_id'))
    {
      return sfView::NONE;
    }

    $this->project = $this->retrieveProject();
    $this->project_report = $this->retrieveProjectReport($this->project);
  }

  public function executeShowSidebar()
  {
    if($this->isRequestFieldEmpty('issue_id'))
    {
      return sfView::NONE;
    }
    
    $this->issue = Doctrine::getTable('Issue')->getIssueById($this->getRequest()->getParameter('issue_id'));
  }
}
?>
