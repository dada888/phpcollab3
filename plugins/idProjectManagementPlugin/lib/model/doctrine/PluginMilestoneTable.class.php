<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PluginMilestoneTable.class.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Model
 */


/**
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Model
 */
class PluginMilestoneTable extends Doctrine_Table
{

  public function getQueryForActiveMilestonesByProjectIds($project_ids)
  {
    return $this->createQuery()
                ->where('closed = 0 ')
                ->andWhereIn('project_id', $project_ids);
  }

  public function getLateMilestonesByProjectIds(array $project_ids)
  {
    return $this->getQueryForActiveMilestonesByProjectIds($project_ids)
                ->andWhere('ending_date < ? ', date('Y-m-d'))
                ->execute();
  }

  public function getUpcomingMilestonesByProjectIds(array $project_ids, $days = 7)
  {
    return $this->getQueryForActiveMilestonesByProjectIds($project_ids)
                ->andWhere('starting_date < ?', date('Y-m-d 23:59:59', strtotime('+'.$days.' days')))
                ->andWhere('starting_date >= ?', date('Y-m-d'))
                ->execute();
  }

  public function getQueryForActiveProjectMilestone($project_id)
  {
    return $this->getQueryForActiveMilestonesByProjectIds(array($project_id));
  }
}