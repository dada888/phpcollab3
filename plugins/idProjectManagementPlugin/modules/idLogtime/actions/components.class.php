<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idLogtimeComponents
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 */

/**
 * idLogtimeComponents class for components in idLogtime modules templates
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idLogtimeComponents extends phpCollabComponents
{
  public function executeSidebar()
  {
    if($this->isRequestFieldEmpty('issue_id'))
    {
      return sfView::NONE;
    }

    $this->project = $this->retrieveProjectByIssue();
    $this->project_report = $this->retrieveProjectReport($this->project);
  }
}
?>
