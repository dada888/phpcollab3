<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PluginProjectTable.class.php
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Model
 */


/**
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    phpCollab3
 * @author Filippo (p16) De Santis <fd@ideato.it>
 * @subpackage idProjectManagmentPlugin Model
 */
class PluginProjectTable extends Doctrine_Table
{

  public function projectExists($project_id)
  {
    $result = Doctrine_Query::create()
            ->from('Project p')
            ->where('p.id = ? ', $project_id)
            ->count();

    return ($result > 0);
  }

  /**
   * Retrive a project and all the related milestones and issues given a project id
   *
   * @param int $id
   * @return Project
   */
  public function getProjectRelatedMilestonesAndIssues($id)
  {
    $q = Doctrine_Query::create()
      ->from('Project p')
      ->leftJoin('p.Milestones m')
      ->leftJoin('m.Issues i')
      ->leftJoin('i.priority pr')
      ->leftJoin('i.status s')
      ->where('p.id = ?', $id);

    return $q->fetchOne();
  }

  /**
   * Retrive a project and all its related milestones and users
   *
   * @param int $id
   * @return Project
   */
  public function getProjectMilestonesAndUsers($id)
  {
    $q = Doctrine_Query::create()
      ->from('Project p')
      ->leftJoin('p.Milestones m')
      ->leftJoin('p.users pr')
      ->leftJoin('pr.User u')
      ->where('p.id = ?', $id);

    return $q->fetchOne();
  }

  /**
   *
   *
   * @param <type> $user
   * @return <type>
   */
  public function getQueryToRetrieveProjectWhereUserHaveAssignedIssues($user_id)
  {
    return Doctrine_Query::create()
            ->from('Project as p')
            ->leftJoin('p.Issues i')
            ->leftJoin('i.users u')
            ->leftJoin('i.status s')
            ->addWhere('u.id = ?', $user_id)
            ->addWhere('s.status_type = ?', 'new')
            ;
  }

  public function getRecentPrjectsIdAndName($limit = 3)
  {
    return $this->createQuery()
                ->select('id, name')
                ->orderBy('created_at DESC')
                ->limit($limit)
                ->execute(array(), Doctrine::HYDRATE_ARRAY);
  }

  public function hasExceededEstimatedHours($project_id)
  {
    $estimated_time = Doctrine::getTable('Issue')->retrieveEstimatedTimeForProject($project_id);
    $log_time = Doctrine::getTable('Issue')->retrieveLogTimeForProject($project_id);

    return ($estimated_time['estimated_time'] > 0 && ($log_time['project_log_times'] > $estimated_time['estimated_time']));
  }


  public function isProjectOnTime($project)
  {
    if (is_numeric($project))
    {
      $project = Doctrine::getTable('Project')->findOneBy('id', $project);
    }

    if (!($project instanceof Project))
    {
      throw new Exception('Error: Can not find project. '. __CLASS__.__FUNCTION__);
    }

    if (!is_null($project->end_date) && ($project->end_date < date('Y-m-d')))
    {
      return Project::LATE;
    }

    if (!is_null($project->end_date) && ($project->end_date > date('Y-m-d')) && $project->hasExceededEstimatedHours())
    {
      return Project::EXCEEDING_ESTIMATION;
    }

    return Project::ONTIME;
  }

  public function getReportOnProject($project_id)
  {
    $project = Doctrine::getTable('Project')->findOneBy('id', $project_id);
    $closed = Doctrine::getTable('Issue')->getQueryForClosedIssueForProject($project_id)->count();
    $assigned = Doctrine::getTable('Issue')->getQueryForAssignedIssueForProject($project_id)->count();
    $all = Doctrine::getTable('Issue')->countByProject($project_id);

    $report = array();
    $report['completion_percentage'] = ($all['issues'] > 0) ? round((100*$closed)/$all['issues'], 2) : 0;
    $report['assigned_percentage'] = ($all['issues'] > 0) ? round((100*$assigned)/$all['issues'], 2) : 0;
    $report['closed_issues'] = $closed;
    $report['remaining_issues'] = $all['issues'] - $closed;
    $report['messages'] = Doctrine::getTable('Message')->getQueryForProjectMessages($project_id)->count();
    $report['project_name'] = $project->name;
    $report['on_time'] = $project->isOnTime();
    return $report;
  }

  public function getReportsForRecentProjects($limit = 3)
  {
    $projects_id_name = Doctrine::getTable('Project')->getRecentPrjectsIdAndName($limit);
    $reports = array();
    foreach ($projects_id_name as $id_name)
    {
      $report = $this->getReportOnProject($id_name['id']);
      $reports[$id_name['id']] = $report;
      
      /** TO DO :numero di commit per il progetto **/
    }

    return $reports;
  }

  protected function initializeEffortDataForChart($days)
  {
    $data = array();
    for($ii = $days-1; $ii >= 0; --$ii)
    {
      $data[date('Y-m-d', strtotime('-'.$ii.' days GMT'))] = 0;
    }
    return $data;
  }

  public function getEffortDataForChart($project_id, $days = 14)
  {
    $chart_data = $this->initializeEffortDataForChart($days);

    $loggedtimes_by_day = Doctrine::getTable('Issue')->retrieveLogTimeForProjectGoupByCreatedAt($project_id, $days);
    foreach($loggedtimes_by_day as $log_info)
    {
      $chart_data[$log_info['date']] = $log_info['logged_time'];
    }
    return $chart_data;
  }

  public function getReportsOnProjectsWithEffortChart($projects, $limit = 3)
  {
    $reports = array();
    foreach ($projects as $key => $project)
    {
      if ($key >= $limit)
      {
        break;
      }
      
      $report = $this->getReportOnProject($project->id);
      $reports[$project->id] = $report;
      $reports[$project->id]['project_name'] = $project->name;
      $reports[$project->id]['on_time'] = $this->isProjectOnTime($project->id);
      $reports[$project->id]['chart'] = $this->getEffortDataForChart($project->id);
    }

    return $reports;
  }

  public function getProjectFromIssueId($issue_id)
  {
    if(!is_null($issue_id))
    {
      return $this->createQuery()->
                    from('Project as p')->
                    leftJoin('p.Issues i')->
                    leftJoin('p.users u')->
                    leftJoin('p.trackers t')->
                    leftJoin('p.Milestones mil')->
                    leftJoin('p.Messages mes')->
                    where('i.id = ?', $issue_id)->
                    fetchOne();
    }
  }

}