<?php
include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');


$issue = Doctrine::getTable('Issue')->createQuery()->fetchOne();

$t = new lime_test(15, new lime_output_color());

$t->like("".$issue, '/#.* new issue/', '__toString() returns the right value');
$t->is($issue->hasComments(), true, 'hasComments() returns the right value');

$issues = Doctrine::getTable('Issue')->countByProject(5);
$t->is($issues['issues'], 15, 'countByProject() returns the right number of issues');

$issues = Doctrine::getTable('Issue')->countByProject();
$t->is($issues, null, 'countByProject() returns null');

$issues = Doctrine::getTable('Issue')->countByProjectWithEstimatedTime(5);
$t->is($issues['issues'], 10, 'countByProjectWithEstimatedTime() returns the right number of issues');

$issues = Doctrine::getTable('Issue')->countByProjectWithEstimatedTime();
$t->is($issues, null, 'countByProjectWithEstimatedTime() returns the right number of issues');

$issues = Doctrine::getTable('Issue')->countByTrackerOfProjectWithEstimatedTime(5);
$t->is($issues[''], 1, 'countByTrackerOfProjectWithEstimatedTime() returns the right number of issues');
$t->is($issues['Task'], 6, 'countByTrackerOfProjectWithEstimatedTime() returns the right number of issues');
$t->is($issues['user story'], 3, 'countByTrackerOfProjectWithEstimatedTime() returns the right number of issues');

$issues = Doctrine::getTable('Issue')->countByTrackerOfProjectWithEstimatedTime();
$t->is($issues, null, 'countByTrackerOfProjectWithEstimatedTime() returns the right number of issues');

$issues = Doctrine::getTable('Issue')->countByTrackerOfProjectWithoutEstimatedTime(5);
$t->is($issues['Bug'], 5, 'countByTrackerOfProjectWithoutEstimatedTime() returns the right number of issues');

$issues = Doctrine::getTable('Issue')->countByTrackerOfProjectWithoutEstimatedTime();
$t->is($issues, null, 'countByTrackerOfProjectWithoutEstimatedTime() returns the right number of issues');

$issues = Doctrine::getTable('Issue')->retrieveEstimatedTimeForProject(5);
$t->is($issues['estimated_time'], 136, 'retrieveEstimatedTimeForProject() returns the right number of issues');

$issues = Doctrine::getTable('Issue')->retrieveEstimatedTimeForProjectMilestone(1, 1);
$t->is($issues['estimated_time'], 101, 'retrieveEstimatedTimeForProjectMilestone() returns the right number of estimated hours');


$issue = Doctrine::getTable('Issue')->find(69);
$t->is($issue->getTotalLogTime(), '2.5', 'getTotalLogTime() ok');
