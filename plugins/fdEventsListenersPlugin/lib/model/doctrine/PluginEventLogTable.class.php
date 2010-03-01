<?php
/**
 */
class PluginEventLogTable extends Doctrine_Table
{
  //seleziona le ultime tre date in cui sono presenti log
  public function getLastDatesOfEvents($days)
  {
    $select = fdDBManager::getSelectForEventLogs();
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

  protected function retrieveEventsByDays($days)
  {
    $latest_dates = $this->getLastDatesOfEvents($days);
    $first_date = date('Y-m-d 00:00:00', strtotime($latest_dates[0]['date'].' +1 day'));
    $last_date  = $latest_dates[count($latest_dates)-1]['date'];

    $until_date = date('Y-m-d 23:59:59', strtotime('-'.$days.' days'));

    return $this->createQuery()
                ->where('created_at < ?', $first_date)
                ->andWhere('created_at >= ?', $last_date)
                ->orderBy('created_at DESC')
                ->execute();
  }

  public function retrieveEventsOfTheLastDays($days, $decorator_class = null)
  {
    return $this->cleanData($this->retrieveEventsByDays($days), $decorator_class);
  }
}