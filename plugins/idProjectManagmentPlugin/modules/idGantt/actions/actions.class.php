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
 * @subpackage idProjectManagmentPlugin Modules
 */

/**
 * idGanttActions actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Modules
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

  protected function getStartingDate($project_starting_date, $add_days_to_the_end = 0)
  {
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
    //crea degli intervalli dal giorno di partenza del progetto alla fine stimata escludento tutti i sabati e le domeniche.
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

    $this->gantt_starting_date =  $this->getStartingDate($project->getstarting_date(), 3);
    $this->project_starting_date = $this->getStartingDate($project->getstarting_date());

    $this->gantt_ending_date = $this->getEndingDate($project->getstarting_date(), $project->getEndDate(), $estimated_time_for_project, 3);
    $this->project_ending_date = $this->getEndingDate($project->getstarting_date(), $project->getEndDate(), $estimated_time_for_project);

    $this->estimated_ending_date = $this->getEstimatedEndingDate($project->getstarting_date(), $estimated_time_for_project, $this->resources);

    $this->days = $this->getDaysFromWorkingHours($estimated_time_for_project);

    $this->processes = $this->retrieveProcessingDatePerResource($this->project_starting_date, $this->project_ending_date, $this->estimated_ending_date, $this->resources);
  }

  public function executeUpdateShow(sfWebRequest $request)
  {
    $this->forwardUnless($this->getUser()->hasCredential('idGantt-View'), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    $this->form = new gnattChartForm();
    $this->show_gantt = $this->validateForm($request, $this->form);
    
    $this->setTemplate('show');
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
