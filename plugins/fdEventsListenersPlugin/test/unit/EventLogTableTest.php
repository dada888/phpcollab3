<?php

include(dirname(__FILE__).'/../../../../test/bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
new sfDatabaseManager($configuration);
Doctrine::loadData(dirname(__FILE__).'/../fixtures/fixtures.yml');

$t = new lime_test(20, new lime_output_color());

$events = Doctrine::getTable('EventLog')->retrieveEventsOfTheLastDays(3);

$t->is(count($events), 3, '->retrieveEventsOfTheLAstDays(3) returns 3 events');

$today = date('Y-m-d');
$yesterday = date('Y-m-d',strtotime('-1 days'));
$two_days_ago = date('Y-m-d', strtotime('-2 days'));

$t->is(count($events[$today]), 1,  'count = 1');
$t->like($events[$today][0]->created_at, '/'.date('Y-m-d H:i').'/',  '->retrieveEventsOfTheLAstDays(3) first result ok');

$t->is(count($events[$yesterday]), 1,  'count = 1');
$t->like($events[$yesterday][0]->created_at, '/'.date('Y-m-d H:i', strtotime('-1 days')).'/',  '->retrieveEventsOfTheLAstDays(3) second result ok');

$t->is(count($events[$two_days_ago]), 1,  'count = 1');
$t->like($events[$two_days_ago][0]->created_at, '/'.date('Y-m-d H:i', strtotime('-2 days')).'/',  '->retrieveEventsOfTheLAstDays(3) third result ok');

$events = Doctrine::getTable('EventLog')->retrieveEventsOfTheLastDays(1);

$t->is(count($events[$today]), 1,  'count = 1');
$t->like($events[$today][0]->created_at, '/'.date('Y-m-d H:i').'/',  '->retrieveEventsOfTheLAstDays(3) first result ok');

$events = Doctrine::getTable('EventLog')->retrieveEventsOfTheLastDaysByProjectsIds(5, array(1,3), null);
$t->is(count($events), 2,  'retrieveEventsOfTheLastDaysByProjectsIds() returns 2 events');
$t->is($events[date('Y-m-d')][0]->project_id, 1, 'found right event');
$t->is($events[date('Y-m-d',strtotime('-2 days'))][0]->project_id, 3, 'found right event');


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
