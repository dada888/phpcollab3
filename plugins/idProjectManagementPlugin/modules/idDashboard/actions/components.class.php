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
class idDashboardComponents extends sfComponents
{
  public function executeAdmin()
  {
    $this->latest_projects_reports = Doctrine::getTable('Project')->getReportsForRecentProjects();
  }

  public function executeCustomer()
  {

  }

  public function executeProjectManager()
  {

  }

  public function executeDeveloper()
  {

  }
}
?>
