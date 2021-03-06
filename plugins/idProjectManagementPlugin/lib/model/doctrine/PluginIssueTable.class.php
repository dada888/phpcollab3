<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PluginIssueTable.class.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Model
 */


/**
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    phpCollab3
 * @author Filippo (p16) De Santis <fd@ideato.it>
 * @subpackage idProjectManagementPlugin Model
 */
class PluginIssueTable extends Doctrine_Table
{
  /**
   * Returns an issue and all it's related object given an issue id.
   *
   * @param integer $issue_id
   * @return Issue
   */
  public function getIssueById($issue_id)
  {
    $q = Doctrine_Query::create()
      ->from('Issue i')
      ->leftJoin('i.milestone m')
      ->leftJoin('i.project p')
      ->leftJoin('i.issues ri')
      ->leftJoin('i.status s')
      ->leftJoin('i.priority pr')
      ->leftJoin('i.tracker t')
      ->Where('i.id = ? ', $issue_id);

    return $q->fetchOne();
  }

  /**
   * Returns a Doctrine_Query object configured to contain the query to retrive all the issue of a milestone given the project id and the milestone id.
   *
   * @param int $project_id
   * @param int $milestone_id
   * @return Doctrine_Query
   */
  public function getQueryForMilstoneIssues($project_id = null, $milestone_id = null)
  {
    if (is_null($milestone_id) || is_null($project_id))
    {
      return null;
    }

    $q = $this->getQueryForProjectIssues($project_id);
    $q->addWhere('i.milestone_id = ?', $milestone_id)
      ->addOrderBy('i.id');
    return $q;
  }

  /**
   * Returns a Doctrine_Query object configured to contain the query for retriving all the issue of a specific project
   *
   * @param int $project_id
   * @return Doctrine_Query
   */
  public function getQueryForProjectIssues($project_id)
  {
    if (is_null($project_id))
    {
      return null;
    }

    $q = Doctrine_Query::create()
      ->from('Issue i')
      ->leftJoin('i.tracker t')
      ->leftJoin('i.milestone m')
      ->orderBy('i.id ASC')
      ->andWhere('i.project_id = ? ', $project_id);

    return $q;
  }

  public function getIssueForProjectOrderedByStatusType($project_id)
  {
    return $this->getQueryForProjectIssues($project_id)
                ->leftJoin('i.status s')
                ->orderBy('s.status_type ASC')
                ->execute();
  }

  public function getQueryForClosedIssueForProject($project_id)
  {
    return $this->getQueryForProjectIssues($project_id)
                ->leftJoin('i.status s')
                ->addWhere('s.status_type = ?', 'closed');
  }

  public function getClosedIssueForProject($project_id)
  {
    return $this->getQueryForClosedIssueForProject($project_id)
                ->execute();
  }

  public function getQueryForInvalidIssueForProject($project_id)
  {
    return $this->getQueryForProjectIssues($project_id)
                ->leftJoin('i.status s')
                ->addWhere('s.status_type = ?', 'invalid');
  }

  public function getInvalidIssueForProject($project_id)
  {
    return $this->getQueryForInvalidIssueForProject($project_id)
                ->execute();
  }

  public function getQueryForNewIssueForProject($project_id)
  {
    return $this->getQueryForProjectIssues($project_id)
                ->leftJoin('i.status s')
                ->addWhere('s.status_type = ?', 'new');
  }

  public function getNewIssueForProject($project_id)
  {
    return $this->getQueryForNewIssueForProject($project_id)
                ->execute();
  }

  public function getQueryForAssignedIssueForProject($project_id)
  {
    return $this->getQueryForProjectIssues($project_id)
                ->leftJoin('i.status s')
                ->addWhere('s.status_type = ?', 'assigned');
  }

  /**
   * Returns a Doctrine_Query object configured to contain the query
   *  to retrive all the issue of a user given the user id
   *
   * @param int $user_id
   * @return Doctrine_Query
   */
  public function getQueryForUserIssues($user_id)
  {
    if (is_null($user_id))
    {
      return null;
    }

    $q = Doctrine_Query::create()
      ->from('Issue i')
      ->leftJoin('i.IssueUsers iu')
      ->leftJoin('i.status s')
      ->leftJoin('i.priority pr')
      ->leftJoin('i.milestone m')
      ->leftJoin('i.tracker t')
      ->where('iu.user_id = ? ', $user_id);

    return $q;
  }

  private function queryForIssuesAssignedToUserByProject($user_id, $project_id)
  {
    return $this->getQueryForUserIssues($user_id)
             ->addWhere('i.project_id = ?', $project_id);
  }

  public function retrieveIssuesAssignedToUserByProject($user_id, $project_id)
  {
    return $this->queryForIssuesAssignedToUserByProject($user_id, $project_id)->execute();
  }

  public function countIssuesAssignedToUserByProject($user_id, $project_id)
  {
    return $this->queryForIssuesAssignedToUserByProject($user_id, $project_id)->count();
  }

  public function countByProject($project_id)
  {
    if (!is_null($q = $this->getQueryForProjectIssues($project_id)))
    {
      return $q->select('COUNT(*) as issues')
               ->fetchOne(array(), Doctrine::HYDRATE_ARRAY);
    }
  }

  public function countByProjectWithEstimatedTime($project_id)
  {
    if (!is_null($q = $this->getQueryForProjectIssues($project_id)))
    {
      return $q->select('COUNT(*) as issues')
               ->addWhere('i.estimated_time IS NOT NULL')
               ->addWhere('i.estimated_time > 0')
               ->fetchOne(array(), Doctrine::HYDRATE_ARRAY);
    }
  }

  protected function formatResultsNumberOfIssuePerTracker($results)
  {

    $trackers_and_issues = array();
    foreach ($results as $tracker_and_issue)
    {
      $trackers_and_issues[$tracker_and_issue[0]] = $tracker_and_issue[1];
    }
    return $trackers_and_issues;
  }

  public function countByTrackerOfProjectWithEstimatedTime($project_id)
  {
    if (!is_null($q = $this->getQueryForProjectIssues($project_id)))
    {
      $results = $q->select('t.name as tracker, COUNT(i.id) as issues')
                   ->addWhere('i.estimated_time IS NOT NULL')
                   ->addWhere('i.estimated_time > 0')
                   ->groupBy('tracker')
                   ->execute(array(), Doctrine::HYDRATE_NONE);

      return $this->formatResultsNumberOfIssuePerTracker($results);
    }
  }


  public function countByTrackerOfProjectWithoutEstimatedTime($project_id)
  {
    if (!is_null($q = $this->getQueryForProjectIssues($project_id)))
    {
      $results = $q->select('t.name as tracker, COUNT(i.id) as issues')
                   ->addWhere('(i.estimated_time IS NULL OR i.estimated_time = 0)')
                   ->groupBy('t.name')
                   ->execute(array(), Doctrine::HYDRATE_NONE);

      return $this->formatResultsNumberOfIssuePerTracker($results);
    }
  }

  public function retrieveEstimatedTimeForProject($project_id)
  {
    if (!is_null($q = $this->getQueryForProjectIssues($project_id)))
    {
      return $q->select('SUM(i.estimated_time) as estimated_time')
               ->fetchOne(array(), Doctrine::HYDRATE_ARRAY);
    }
  }

  public function retrieveLogTimeForProject($project_id)
  {
    if (!is_null($q = $this->getQueryForProjectIssues($project_id)))
    {
      return $q->select('SUM(l.log_time) as project_log_times')
               ->leftJoin('i.logtimes l')
               ->fetchOne(array(), Doctrine::HYDRATE_ARRAY);
    }
  }

  public function retrieveLogTimeForProjectGoupByCreatedAt($project_id, $days = 14)
  {
    return Doctrine::getTable('LogTime')
              ->createQuery()
              ->select('SUM(l.log_time) as logged_time, l.id, '.fdDBManager::getSQLToFormatDateToYearMonthDay('l.created_at'))
              ->from('LogTime l')
              ->leftJoin('l.issue i')
              ->andWhere('l.created_at >= ?', date('Y-m-d 23:59:59', strtotime('-'.$days.' days GMT')))
              ->andWhere('i.project_id = ? ', $project_id)
              ->groupBy('date')
              ->execute(array(), Doctrine::HYDRATE_ARRAY);
  }

  public function retrieveEstimatedTimeForProjectMilestone($project_id, $milestone_id)
  {
    if (!is_null($q = $this->getQueryForProjectIssues($project_id)))
    {
      return $q->select('SUM(i.estimated_time) as estimated_time')
               ->addWhere('i.milestone_id = ?', $milestone_id)
               ->fetchOne(array(), Doctrine::HYDRATE_ARRAY);
    }
  }

  public function retrieveLogTimeForProjectMilestone($project_id, $milestone_id)
  {
    if (!is_null($q = $this->getQueryForProjectIssues($project_id)))
    {
      return $q->select('SUM(l.log_time) as milestone_log_times')
               ->leftJoin('i.logtimes l')
               ->addWhere('i.milestone_id = ?', $milestone_id)
               ->fetchOne(array(), Doctrine::HYDRATE_ARRAY);
    }
  }

  public function getSpentTimeOnIssuesClosedAndInvalidForProject($project_id)
  {
    if (!is_null($q = $this->getQueryForProjectIssues($project_id)))
    {
      return $q->select('SUM(l.log_time) as project_log_times')
               ->leftJoin('i.logtimes l')
               ->leftJoin('i.status s')
               ->addWhere('(s.status_type = ? OR s.status_type = ? )', array('closed', 'invalid'))
               ->fetchOne(array(), Doctrine::HYDRATE_ARRAY);
    }
  }

  public function getOpenIssuesEstimatedTimeForProject($project_id)
  {
    if (!is_null($q = $this->getQueryForProjectIssues($project_id)))
    {
      return $q->select('SUM(i.estimated_time) as estimated_time')
               ->leftJoin('i.status s')
               ->addWhere('s.status_type = ?', 'new')
               ->fetchOne(array(), Doctrine::HYDRATE_ARRAY);
    }
  }

  public function getLateIssuesForUserByUserId($user_id)
  {
    $query = $this->getQueryForUserIssues($user_id);
    return $query->andWhere('i.ending_date < ? ', date('Y-m-d'))
                 ->andWhere('(s.status_type <> ? OR s.status_type <> ? )', array('closed', 'invalid'))
                 ->execute();
  }

  public function getUpcomingIssuesForUserByUserId($user_id, $days = 7)
  {
    $query = $this->getQueryForUserIssues($user_id);
    return $query->andWhere('i.starting_date >= ? ', date('Y-m-d'))
                 ->andWhere('i.starting_date <= ? ', date('Y-m-d', strtotime('+'.$days.' days')))
                 ->andWhere('(s.status_type <> ? OR s.status_type <> ? )', array('closed', 'invalid'))
                 ->execute();
  }
}