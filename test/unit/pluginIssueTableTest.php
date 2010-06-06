<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
$database_manager = new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');

$t = new lime_test(57, new lime_output_color());

$issue = Doctrine::getTable('Issue')->getIssueById(12);
$t->ok($issue instanceof Issue, '->getIssueById() returns the right object');
$t->ok($issue->getId() == 12, '->getIssueById() returns an object of with the right id');


$t->ok(Doctrine::getTable('Issue')->getQueryForMilstoneIssues(2, 2) instanceof Doctrine_Query, '->getQueryForMilstoneIssues(2, 2) returns a doctrine query object');
$t->is(Doctrine::getTable('Issue')->getQueryForMilstoneIssues(), null, '->getQueryForMilstoneIssues() returns null');

$t->ok(Doctrine::getTable('Issue')->getQueryForProjectIssues(2) instanceof Doctrine_Query, '->getQueryForProjectIssues(2) returns a doctrine query object');
$t->is(Doctrine::getTable('Issue')->getQueryForMilstoneIssues(), null, '->getQueryForProjectIssues() returns null');

$t->ok(Doctrine::getTable('Issue')->getQueryForUserIssues(2) instanceof Doctrine_Query, '->getQueryForUserIssues(2) returns a doctrine query object');
$t->is(Doctrine::getTable('Issue')->getQueryForUserIssues(), null, '->getQueryForUserIssues() returns null');

$logtimes = Doctrine::getTable('Issue')->retrieveLogTimeForProject(5);
$t->is($logtimes['project_log_times'], '15', '->retrieveLogTimeForProject(5) returns a doctrine query object');
$logtimes = Doctrine::getTable('Issue')->retrieveLogTimeForProject();
$t->is(Doctrine::getTable('Issue')->retrieveLogTimeForProject(), null, '->retrieveLogTimeForProject() returns null');

$results = Doctrine::getTable('Issue')->getIssueForProjectOrderedByStatusType(2);

$t->is(count($results), 6, 'getIssueForProjectOrderedByStatusType return the right numebr of results');
$t->is($results[0]->getStatus()->getStatusType(), 'invalid', 'getIssueForProjectOrderedByStatusType return the right numebr of results');
$t->is($results[1]->getStatus()->getStatusType(), 'new', 'getIssueForProjectOrderedByStatusType return the right numebr of results');

$result = Doctrine::getTable('Issue')->getSpentTimeOnIssuesClosedAndInvalidForProject(3);
$t->is($result['project_log_times'], null, 'getSpentTimeOnIssuesClosedAndInvalidForProject ok');
$result = Doctrine::getTable('Issue')->getOpenIssuesEstimatedTimeForProject(3);
$t->is($result['estimated_time'], 95, 'getOpenIssuesEstimatedTimeForProject(3) ok');

$result = Doctrine::getTable('Issue')->getSpentTimeOnIssuesClosedAndInvalidForProject(5);
$t->is($result['project_log_times'], null, 'getSpentTimeOnIssuesClosedAndInvalidForProject ok');
$result = Doctrine::getTable('Issue')->getOpenIssuesEstimatedTimeForProject(5);
$t->is($result['estimated_time'], 136, 'getOpenIssuesEstimatedTimeForProject(5) ok');

$result = Doctrine::getTable('Issue')->getSpentTimeOnIssuesClosedAndInvalidForProject(1);
$t->is($result['project_log_times'], 203, 'getSpentTimeOnIssuesClosedAndInvalidForProject ok');
$result = Doctrine::getTable('Issue')->getOpenIssuesEstimatedTimeForProject(1);
$t->is($result['estimated_time'], 126, 'getOpenIssuesEstimatedTimeForProject(1) ok');

$results = Doctrine::getTable('Issue')->getClosedIssueForProject(2);
$t->is(count($results), 0, 'getClosedIssueForProject ok');

$results = Doctrine::getTable('Issue')->getNewIssueForProject(2);
$t->is(count($results), 5, 'getNewIssueForProject ok');

$results = Doctrine::getTable('Issue')->getInvalidIssueForProject(2);
$t->is(count($results), 1, 'getInvalidIssueForProject ok');

$results = Doctrine::getTable('Issue')->getQueryForAssignedIssueForProject(1)->count();
$t->is($results, 1, 'getQueryForAssignedIssueForProject ok');

/*estimated and logged time for milstones issues*/

$result = Doctrine::getTable('Issue')->retrieveLogTimeForProjectMilestone(1, 1);
$t->is($result['milestone_log_times'], 32, 'retrieveLogTimeForProjectMilestone(1,1) ok');
$result = Doctrine::getTable('Issue')->retrieveEstimatedTimeForProjectMilestone(1, 1);
$t->is($result['estimated_time'], 101, 'retrieveEstimatedTimeForProjectMilestone(1,1) ok');


$result = Doctrine::getTable('Issue')->retrieveLogTimeForProjectMilestone(1, 2);
$t->is($result['milestone_log_times'], 205.5, 'retrieveLogTimeForProjectMilestone(1,2) ok');
$result = Doctrine::getTable('Issue')->retrieveEstimatedTimeForProjectMilestone(1, 2);
$t->is($result['estimated_time'], 185, 'retrieveEstimatedTimeForProjectMilestone(1,2) ok');

$result = Doctrine::getTable('Issue')->retrieveLogTimeForProjectMilestone(3, 3);
$t->is($result['milestone_log_times'], null, 'retrieveLogTimeForProjectMilestone(3,3) ok');
$result = Doctrine::getTable('Issue')->retrieveEstimatedTimeForProjectMilestone(3, 3);
$t->is($result['estimated_time'], 95, 'retrieveEstimatedTimeForProjectMilestone(3,3) ok');

$result = Doctrine::getTable('Issue')->retrieveLogTimeForProjectMilestone(2, 4);
$t->is($result['milestone_log_times'], null, 'retrieveLogTimeForProjectMilestone(2,4) ok');
$result = Doctrine::getTable('Issue')->retrieveEstimatedTimeForProjectMilestone(2, 4);
$t->is($result['estimated_time'], 0, 'retrieveEstimatedTimeForProjectMilestone(2,4) ok');

$result = Doctrine::getTable('Issue')->retrieveLogTimeForProjectMilestone(2, 5);
$t->is($result['milestone_log_times'], null, 'retrieveLogTimeForProjectMilestone(2,5) ok');
$result = Doctrine::getTable('Issue')->retrieveEstimatedTimeForProjectMilestone(2, 5);
$t->is($result['estimated_time'], 0, 'retrieveEstimatedTimeForProjectMilestone(2,5) ok');

/* late and upcoming issue for user*/


$late = Doctrine::getTable('Issue')->getLateIssuesForUserByProfileId(2);
$t->is(count($late), 2, '->getLateIssuesForUserByProfileId(2) retireves the right number of issues');
$t->is($late[0]->id, 91, 'retrieved right issue');
$t->is($late[1]->id, 92, 'retrieved right issue');
$upcoming = Doctrine::getTable('Issue')->getUpcomingIssuesForUserByProfileId(2);
$t->is(count($upcoming), 11, '->getUpcomingIssuesForUserByProfileId(2) retireves the right number of issues');
$t->is($upcoming[4]->id, 6, 'retrieved right issue');
$t->is($upcoming[10]->id, 12, 'retrieved right issue');

$late = Doctrine::getTable('Issue')->getLateIssuesForUserByProfileId(3);
$t->is(count($late), 0, '->getLateIssuesForUserByProfileId(3) retireves the right number of issues');
$upcoming = Doctrine::getTable('Issue')->getUpcomingIssuesForUserByProfileId(3);
$t->is(count($upcoming), 3, '->getUpcomingIssuesForUserByProfileId(3) retireves the right number of issues');
$t->is($upcoming[0]->id, 1, 'retrieved right issue');
$t->is($upcoming[1]->id, 2, 'retrieved right issue');
$t->is($upcoming[2]->id, 70, 'retrieved right issue');


/*log time grouped by date*/

$dates_logtime = Doctrine::getTable('Issue')->retrieveLogTimeForProjectGoupByCreatedAt(1);
$t->is(count($dates_logtime), 6, '->retrieveLogTimeForProjectGoupByCreatedAt() returns the right number of dates');

$t->is($dates_logtime[0]['date'], date('Y-m-d', strtotime('-5 days')), '->retrieveLogTimeForProjectGoupByCreatedAt() returns the right date');
$t->is($dates_logtime[0]['logged_time'], 16, '->retrieveLogTimeForProjectGoupByCreatedAt() returns the right logged time');

$t->is($dates_logtime[1]['date'], date('Y-m-d', strtotime('-4 days')), '->retrieveLogTimeForProjectGoupByCreatedAt() returns the right date');
$t->is($dates_logtime[1]['logged_time'], 16, '->retrieveLogTimeForProjectGoupByCreatedAt() returns the right logged time');

$t->is($dates_logtime[2]['date'], date('Y-m-d', strtotime('-3 days')), '->retrieveLogTimeForProjectGoupByCreatedAt() returns the right date');
$t->is($dates_logtime[2]['logged_time'], 41, '->retrieveLogTimeForProjectGoupByCreatedAt() returns the right logged time');

$t->is($dates_logtime[3]['date'], date('Y-m-d', strtotime('-2 days')), '->retrieveLogTimeForProjectGoupByCreatedAt() returns the right date');
$t->is($dates_logtime[3]['logged_time'], 82, '->retrieveLogTimeForProjectGoupByCreatedAt() returns the right logged time');

$t->is($dates_logtime[4]['date'], date('Y-m-d', strtotime('-1 days')), '->retrieveLogTimeForProjectGoupByCreatedAt() returns the right date');
$t->is($dates_logtime[4]['logged_time'], 81.3, '->retrieveLogTimeForProjectGoupByCreatedAt() returns the right logged time');

$t->is($dates_logtime[5]['date'], date('Y-m-d'), '->retrieveLogTimeForProjectGoupByCreatedAt() returns the right date');
$t->is($dates_logtime[5]['logged_time'], 1.2, '->retrieveLogTimeForProjectGoupByCreatedAt() returns the right logged time');

