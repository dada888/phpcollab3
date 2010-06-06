<?php
include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');


$t = new lime_test(6, new lime_output_color());

$logTimes = Doctrine::getTable('LogTime')->getLogTimeByIssueAndProfile(69, 7);

$t->is($logTimes->count(), 1, 'returns 1 log time');
$log_time = $logTimes->getFirst();
$t->is($log_time->issue->getId(), '69', 'return the right issue');
$t->is($log_time->profile->getId(), '7', 'return the right profile');
$t->like($log_time->created_at, '/'.date('Y-m-d', time()).'/', 'return the right date');
$t->is($log_time->log_time, '1.2', 'return the right time');

$logTimes = Doctrine::getTable('LogTime')->getLogtimeForProjectByUser(5);
$t->is($logTimes->count(), 2, 'returns 5 log time');
