<?php

use_helper('Url');

function link_project($name, $id, $class = '')
{
  if (!is_null($name) && !is_null($id))
  {
    return link_to($name, '@show_project?id='.$id, array('absolute_url' => false, 'class' => $class));
  }
  
  if (!is_null($name) && is_null($id))
  {
    return $name;
  }
}

function get_css_class_based_on_project_on_time($code)
{
  switch ($code)
  {
    case Project::EXCEEDING_ESTIMATION:
      return 'yellow';
    case Project::LATE:
      return 'red';
    default:
      return 'green';
  }
}

function get_css_class_based_on_project_on_budget($on_budget)
{
  return ($on_budget) ? 'green' : 'red' ;
}

function get_days_of_difference($first_date, $second_date)
{
  $start_ts = strtotime($first_date);
  $end_ts = strtotime($second_date);
  $diff = abs($end_ts - $start_ts);
  return round($diff / 86400);
}

function calculate_max_logged_time(array $times)
{
  return max($times);
}

function calculate_proportion($portion, $total)
{
  if (empty($total))
  {
    return 0;
  }
  
  return (float)($portion*100)/$total;
}

function get_color_for_issue(Issue $issue)
{
  if ($issue->isLate())
  {
    return 'red';
  }

  if ($issue->isUpcoming())
  {
    return 'green';
  }
}
