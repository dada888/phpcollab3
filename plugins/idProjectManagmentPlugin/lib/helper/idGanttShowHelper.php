<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Helpers
 */

/**
 * Helper for displaying pages navigation.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Helpers
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */

function isDateInBetweenByMonth($date, $stating_date, $ending_date)
{
  $start = date('Y-m', strtotime($stating_date));
  $end = date('Y-m', strtotime($ending_date));
  $date = date('Y-m', strtotime($date));
  return ($start <= $date && $date <= $end);
}

function getLastDayOfMonth($year, $month)
{
  return date('t', strtotime("$year-$month-01"));
}

function isDateInBetweenByDay($date, $stating_date, $ending_date)
{
  return ($stating_date <= $date && $date <= $ending_date);
}

function getLatestDateOfMonth($year, $month, $format = 'Y/m/d')
{
  $day = date('t', strtotime("$year-$month-01"));
  return date($format, strtotime("$year-$month-$day"));
}

function isLastCategoryByMonth($date, $gantt_ending_date, $separator = '/')
{
  list($year, $month) = explode($separator, $date);
  return (getLatestDateOfMonth($year, $month) >= $gantt_ending_date);
}

/**
 * @todo : find a way to return a correct url without "hardcoding" it.
 *
 * @return string
 */
function retriveSwfUrl()
{
  $env = sfConfig::get('sf_environment');
  if ($env == 'demo')
  {
    return '/demo/idProjectManagmentPlugin/Charts/FCF_Gantt.swf';
  }

  if ($env == 'phpcollabdev')
  {
    return '/phpcollab_dev/idProjectManagmentPlugin/Charts/FCF_Gantt.swf';
  }

  return '/idProjectManagmentPlugin/Charts/FCF_Gantt.swf';
}