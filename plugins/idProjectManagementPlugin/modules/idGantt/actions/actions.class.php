<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idGanttActions actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 */

/**
 * idGanttActions actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Modules
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idGanttActions extends sfActions
{
  protected function setParametersForLegenda($project_id)
  {
    $this->issues_number = Doctrine::getTable('Issue')->countByProject($project_id);
    $this->issues_with_estimated_time = Doctrine::getTable('Issue')
                                        ->countByProjectWithEstimatedTime($project_id);
    $this->issues_by_tracker_with_estimated_time = Doctrine::getTable('Issue')
                                                   ->countByTrackerOfProjectWithEstimatedTime($project_id);
    $this->issues_by_tracker_without_estimated_time = Doctrine::getTable('Issue')
                                                      ->countByTrackerOfProjectWithoutEstimatedTime($project_id);
  }
  
  /**
   * Executes show action
   *
   * @param sfWebRequest $request
   */
  public function executeShow(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idGantt-View'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->form = new gnattChartForm();
    $this->show_gantt = false;
  }

  protected function getStartingDate($project, $add_days_to_the_end = 0)
  {
    $project_starting_date = !is_null($project->getstarting_date()) ? $project->getstarting_date() : $project->getcreated_at() ;
    list($project_starting_date) = explode(' ', $project_starting_date);
    return date('Y/m/d',strtotime("$project_starting_date -$add_days_to_the_end days"));
  }

  protected function getDaysFromWorkingHours($hours, $working_hours_per_day = 8, $working_days_per_week = 5)
  {
    $days = $hours / $working_hours_per_day;
    $weeks = ceil($days/$working_days_per_week);
    return ($weeks*7);
  }

  protected function getEndingDate($project_starting_date, $project_ending_date, $estimated_time_for_project, $add_days_to_the_end = 0)
  {
    if (empty($project_ending_date))
    {
      $days = $this->getDaysFromWorkingHours($estimated_time_for_project) + $add_days_to_the_end;
      return date('Y/m/d', strtotime("$project_starting_date +$days days"));
    }

    list($project_ending_date) = explode(' ', $project_ending_date);
    return date('Y/m/d',strtotime("$project_ending_date +$add_days_to_the_end days"));
  }

  protected function getEstimatedEndingDate($project_starting_date, $estimated_time_for_project, $resources)
  {
    $days = ceil(($this->getDaysFromWorkingHours($estimated_time_for_project))/$resources);
    return date('Y/m/d', strtotime("$project_starting_date +$days days"));
  }

  protected function retrieveWorkingIntervals($project_starting_date, $estimated_ending_date)
  {
    $intervals = array();
    $index = 0;
    $date = $project_starting_date;
    while ($date <= $estimated_ending_date)
    {
      $day_letteral = date('D',strtotime("$date"));
      if ( $day_letteral == 'Sat' || $day_letteral == 'Sun')
      {
        $index++;
        $date = date('Y/m/d',strtotime("$date +2 days"));
        continue;
      }

      if (!isset($intervals[$index]))
      {
        $intervals[$index]['start'] = $date;
      }

      $intervals[$index]['end'] = $date;
      $date = date('Y/m/d',strtotime("$date +1 days"));
    }
    return $intervals;
  }

  protected function retrieveProcessingDatePerResource($project_starting_date, $project_ending_date, $estimated_ending_date, $resources)
  {
    $working_intervals = $this->retrieveWorkingIntervals($project_starting_date, $estimated_ending_date);
    $intervals_per_resource = array();
    for($resource = 1; $resource <= $resources; $resource++)
    {
      foreach ($working_intervals as $interval)
      {
        $intervals_per_resource[$resource][] = $interval;
      }
    }
    return $intervals_per_resource;
  }

  public function executeXmlAnalysisGanttData(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idGantt-View'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($project = Doctrine::getTable('Project')->find($request->getParameter('project_id')));

    $results = Doctrine::getTable('Issue')->retrieveEstimatedTimeForProject($project->getId());
    $estimated_time_for_project = $results['estimated_time'];

    $this->resources = $request->getParameter('resources');

    $this->gantt_starting_date =  $this->getStartingDate($project, 3);
    $this->project_starting_date = $this->getStartingDate($project);

    $this->gantt_ending_date = $this->getEndingDate($project->getstarting_date(), $project->getEndDate(), $estimated_time_for_project, 3);
    $this->project_ending_date = $this->getEndingDate($project->getstarting_date(), $project->getEndDate(), $estimated_time_for_project);

    $this->estimated_ending_date = $this->getEstimatedEndingDate($project->getstarting_date(), $estimated_time_for_project, $this->resources);

    $this->days = $this->getDaysFromWorkingHours($estimated_time_for_project);

    $this->tasks = $this->retrieveProcessingDatePerResource($this->project_starting_date, $this->project_ending_date, $this->estimated_ending_date, $this->resources);
  }

  public function executeXmlProjectStatusGanttData(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idGantt-View'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->forward404Unless($project = Doctrine::getTable('Project')->find($request->getParameter('project_id')));
    
    $this->closed_issues = Doctrine::getTable('Issue')->getClosedIssueForProject($project->id);
    $this->new_issues = Doctrine::getTable('Issue')->getNewIssueForProject($project->id);
    $this->invalid_issues = Doctrine::getTable('Issue')->getInvalidIssueForProject($project->id);
    
    $hours_issues_closed_or_invalid = Doctrine::getTable('Issue')->getSpentTimeOnIssuesClosedAndInvalidForProject($project->id);
    $hours_issues_open = Doctrine::getTable('Issue')->getOpenIssuesEstimatedTimeForProject($project->id);
    
    $this->gantt_starting_date =  $this->getStartingDate($project, 3);

    $this->gantt_ending_date = $this->getEndingDate($this->gantt_starting_date,
                                                    null,
                                                    $hours_issues_closed_or_invalid['project_log_times']+$hours_issues_open['estimated_time'],
                                                    3);

    $this->project_starting_date = $this->getStartingDate($project);
    $this->project_ending_date = $this->getEndingDate($project->getstarting_date(), 
                                                      null,
                                                      $hours_issues_closed_or_invalid['project_log_times']+$hours_issues_open['estimated_time']);
    $this->days = $this->getDaysFromWorkingHours($hours_issues_closed_or_invalid['project_log_times']+$hours_issues_open['estimated_time']);
    $this->estimated_ending_date = $this->getEstimatedEndingDate(date('Y-m-d', time()), $hours_issues_open['estimated_time'], 1);
  }

  public function executeAnalysisGanttChartShow(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idGantt-View'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->form = new gnattChartForm();
    $this->show_gantt = $this->validateForm($request, $this->form);
  }

  public function executeProjectStatusGanttChartShow(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idGantt-View'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->title = 'Status gantt chart';

    $project_id = $request->getParameter('project_id');

    $this->closed_issues_count = Doctrine::getTable('Issue')->getQueryForClosedIssueForProject($project_id)->count();
    $this->new_issues_count = Doctrine::getTable('Issue')->getQueryForNewIssueForProject($project_id)->count();
    $this->invalid_issues_count = Doctrine::getTable('Issue')->getQueryForInvalidIssueForProject($project_id)->count();
    
    $hours_issues_open = Doctrine::getTable('Issue')->getOpenIssuesEstimatedTimeForProject($project_id);
    $this->estimated_time_to_end = $hours_issues_open['estimated_time'];
    $this->estimated_end_date = $this->getEstimatedEndingDate(date('Y-m-d', time()), $hours_issues_open['estimated_time'], 1);

    $this->show_gantt = true;
  }

  private function validateForm(sfWebRequest $request, sfForm $form)
  {
    $parameters = $request->getParameter($form->getName());
    $form->bind($parameters);
    if ($form->isValid())
    {
      //fai il bellissimo gantt
      $this->setParametersForLegenda($request->getParameter('project_id'));
      $this->resources = $parameters['resources_number'];
      $this->title = 'Analysis gantt chart';
      return true;
    }
    return false;
  }

}
