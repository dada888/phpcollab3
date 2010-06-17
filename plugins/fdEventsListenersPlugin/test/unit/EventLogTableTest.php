<?php

include(dirname(__FILE__).'/../../../../test/bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
new sfDatabaseManager($configuration);
Doctrine::loadData(dirname(__FILE__).'/../fixtures/fixtures.yml');

$t = new lime_test(38, new lime_output_color());

$events = Doctrine::getTable('EventLog')->retrieveEventsOfTheLastDays(3);

$t->is(count($events), 3, '->retrieveEventsOfTheLAstDays(3) returns 3 events');

$today = date('Y-m-d', strtotime('today'));
$yesterday = date('Y-m-d',strtotime('-1 days'));
$two_days_ago = date('Y-m-d', strtotime('-2 days'));

$t->is(count($events[$today]), 1,  'count = 1');
$t->like($events[$today][0]->created_at, '/'.date('Y-m-d H:i', strtotime('today')).'/',  '->retrieveEventsOfTheLAstDays(3) first result ok');

$t->is(count($events[$yesterday]), 1,  'count = 1');
$t->like($events[$yesterday][0]->created_at, '/'.date('Y-m-d H:i', strtotime('-1 days')).'/',  '->retrieveEventsOfTheLAstDays(3) second result ok');

$t->is(count($events[$two_days_ago]), 1,  'count = 1');
$t->like($events[$two_days_ago][0]->created_at, '/'.date('Y-m-d H:i', strtotime('-2 days')).'/',  '->retrieveEventsOfTheLAstDays(3) third result ok');

$events = Doctrine::getTable('EventLog')->retrieveEventsOfTheLastDays(1);

$t->is(count($events[$today]), 1,  'count = 1');
$t->like($events[$today][0]->created_at, '/'.date('Y-m-d H:i', strtotime('today')).'/',  '->retrieveEventsOfTheLAstDays(3) first result ok');

$events = Doctrine::getTable('EventLog')->retrieveEventsOfTheLastDaysByProjectsIds(5, array(1,3), null);
$t->is(count($events), 2,  'retrieveEventsOfTheLastDaysByProjectsIds() returns 2 events');
$t->is($events[date('Y-m-d')][0]->project_id, 1, 'found right event');
$t->is($events[date('Y-m-d',strtotime('-2 days'))][0]->project_id, 3, 'found right event');


$activities = Doctrine::getTable('EventLog')->retrieveLastLoggedEventFromProjects(array(1,2,3,4,5));
$t->is(count($activities), 4, '->retrieveLastLoggedEventFromProjects() returns 4 records');
$t->ok($activities[0] instanceof EventLog, '->retrieveLastLoggedEventFromProjects() returns 4 EventLog objects');
$t->is($activities[0]->id, '1', 'id is ok');
$t->is($activities[0]->project_id, '1', 'project_id is ok');
$t->is($activities[1]->id, '2', 'id is ok');
$t->is($activities[1]->project_id, '2', 'project_id is ok');
$t->is($activities[2]->id, '3', 'id is ok');
$t->is($activities[2]->project_id, '3', 'project_id is ok');
$t->is($activities[3]->id, '4', 'id is ok');
$t->is($activities[3]->project_id, '4', 'project_id is ok');

$activities = Doctrine::getTable('EventLog')->retrieveLastLoggedEventFromProjects(array(1,2,3,4,5), date('Y-m-d', strtotime('-1 hour')));
$t->is(count($activities), 1, '->retrieveLastLoggedEventFromProjects() returns 1 record');
$t->ok($activities[0] instanceof EventLog, '->retrieveLastLoggedEventFromProjects() returns 1 EventLog object');
$t->is($activities[0]->id, '1', 'id is ok');
$t->is($activities[0]->project_id, '1', 'project_id is ok');

$result = Doctrine::getTable('EventLog')->retrieveLastEventsByProjectIds(3, array(1,2,3,4));
$t->is(count($result), 3, 'retrieveLastEventsByProjectIds() retrieves the right number of events');

$result = Doctrine::getTable('EventLog')->retrieveLastEventsByProjectIds(1, array(1,3), 'LogDecorator');
$t->is(count($result), 1, 'retrieveLastEventsByProjectIds() retrieves the right number of events');

foreach ($result as $key => $event)
{
  $t->is($event[0]->namespace, 'issue', 'right namespace');
  $t->is($event[0]->action, 'creation', 'right action');
}

initializeDatabase();
Doctrine::loadData(dirname(__FILE__).'/../fixtures/fixtures_old_log.yml');

$dates = Doctrine::getTable('EventLog')->getLastDatesOfEvents(3);
$events = Doctrine::getTable('EventLog')->retrieveEventsOfTheLastDays(3);

$four = date('Y-m-d',strtotime('-4 days'));
$seven = date('Y-m-d',strtotime('-7 days'));
$twelve = date('Y-m-d', strtotime('-12 days'));

$t->is(count($events[$four]), 1,  'count = 1');
$t->like($events[$four][0]->created_at, '/'.date('Y-m-d H:i',strtotime('-4 days')).'/',  '->retrieveEventsOfTheLAstDays(3) first result ok');

$t->is(count($events[$seven]), 1,  'count = 1');
$t->like($events[$seven][0]->created_at, '/'.date('Y-m-d H:i', strtotime('-7 days')).'/',  '->retrieveEventsOfTheLAstDays(3) second result ok');

$t->is(count($events[$twelve]), 1,  'count = 1');
$t->like($events[$twelve][0]->created_at, '/'.date('Y-m-d H:i', strtotime('-12 days')).'/',  '->retrieveEventsOfTheLAstDays(3) third result ok');

$events = Doctrine::getTable('EventLog')->retrieveEventsOfTheLastDays(1);

$t->is(count($events[$four]), 1,  'count = 1');
$t->like($events[$four][0]->created_at, '/'.date('Y-m-d H:i',strtotime('-4 days')).'/',  '->retrieveEventsOfTheLAstDays(3) first result ok');
