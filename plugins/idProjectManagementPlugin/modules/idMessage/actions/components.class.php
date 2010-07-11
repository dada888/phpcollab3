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
class idMessageComponents extends phpCollabComponents
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
}
?>
