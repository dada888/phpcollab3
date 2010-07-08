<?php

class LogTimeFormFactory
{
  public function build($type, $project_id = null, $log_time = null)
  {
    switch ($type)
    {
      case 'project':
        return new projectLogTimeForm($project_id, $log_time);
      case 'issue':
        return new issueLogTimeForm($log_time);
      default:
        return new LogTimeForm($log_time);
    }
  }

}
