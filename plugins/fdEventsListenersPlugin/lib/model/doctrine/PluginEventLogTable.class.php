<?php
/**
 */
class PluginEventLogTable extends Doctrine_Table
{
  //seleziona le ultime tre date in cui sono presenti log
  public function getLastDatesOfEvents($days)
  {
    $select = fdDBManager::getSQLToFormatDateToYearMonthDay();
    return $this->createQuery()
                ->select($select)
                ->groupBy('date')
                ->orderBy('date DESC')
                ->limit($days)
                ->execute(array(), Doctrine::HYDRATE_ARRAY);
  }

  protected function cleanData($event_logs, $decorator_class = null)
  {
    $clean_result_by_date = array();
    foreach ($event_logs as $log)
    {
      list($date) = explode(' ', $log->created_at);
      if (!is_null($decorator_class))
      {
        $log = new $decorator_class($log);
      }
      $clean_result_by_date[$date][] = $log;
    }

    return $clean_result_by_date;
  }

  protected function getQueryToRetrieveEventsByDays($days)
  {
    $latest_dates = $this->getLastDatesOfEvents($days);
    $first_date = date('Y-m-d 00:00:00', strtotime($latest_dates[0]['date'].' +1 day GMT'));
    $last_date  = $latest_dates[count($latest_dates)-1]['date'];

    $until_date = date('Y-m-d 23:59:59', strtotime('-'.$days.' days GMT'));

    return $this->createQuery()
                ->from('EventLog e')
                ->leftJoin('e.Project')
                ->where('created_at < ?', $first_date)
                ->andWhere('created_at >= ?', $last_date)
                ->orderBy('created_at DESC');
  }

  protected function retrieveEventsByDays($days)
  {
    return $this->getQueryToRetrieveEventsByDays($days)->execute();
  }

  protected function retrieveEventsByDaysAndProjectIds($days, $project_ids)
  {
    return $this->getQueryToRetrieveEventsByDays($days)
                ->andWhereIn('project_id', $project_ids)
                ->execute();
  }

  public function retrieveEventsOfTheLastDays($days, $decorator_class = null)
  {
    return $this->cleanData($this->retrieveEventsByDays($days), $decorator_class);
  }

  public function retrieveEventsOfTheLastDaysByProjectsIds($days, $project_ids, $decorator_class = null)
  {
    return $this->cleanData($this->retrieveEventsByDaysAndProjectIds($days, $project_ids), $decorator_class);
  }

  public function retrieveLastEventsByProjectIds($events_number, $project_ids, $decorator_class = null)
  {
    $result = $this->createQuery()
                ->from('EventLog e')
                ->leftJoin('e.Project')
                ->limit($events_number)
                ->orderBy('created_at DESC')
                ->WhereIn('project_id', $project_ids)
                ->execute();

    if ($decorator_class)
    {
      $result = $this->cleanData($result, $decorator_class);
    }
    
    return $result;
  }

  public function retrieveLastLoggedEventFromProjects($project_ids, $min_date = null, $limit = 10)
  {
    if (is_null($min_date))
    {
      $min_date = date('Y-m-d H:i:s', strtotime('1970-01-01'));
    }

    return $this->createQuery()
                 ->from('EventLog el')
                 ->leftJoin('el.Project')
                 ->groupBy('el.project_id')->having('MAX(el.created_at)')
                 ->limit($limit)
                 ->where('el.created_at > ?', $min_date)
                 ->andWhereIn('el.project_id', $project_ids)
                 ->execute();
  }
}