<?php
include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');

$t = new lime_test(8, new lime_output_color());

$late_milestones = Doctrine::getTable('Milestone')->getLateMilestonesByProjectIds(array(1,3));
$t->is(count($late_milestones), 2, 'getLateMilestonesByProjectIds() returns the right number of milestones');
$t->is($late_milestones[0]->title, 'first iteration', 'getLateMilestonesByProjectIds() returns the right milestone');
$t->is($late_milestones[0]->project_id, 1, 'getLateMilestonesByProjectIds() returns the right milestone');
$t->is($late_milestones[1]->title, 'third iteration', 'getLateMilestonesByProjectIds() returns the right milestone');

$upcoming_milestones = Doctrine::getTable('Milestone')->getUpcomingMilestonesByProjectIds(array(1,2));
$t->is(count($upcoming_milestones), 2, 'getUpcomingMilestonesByProjectIds() returns the right number of milestones');
$t->is($upcoming_milestones[0]->title, 'second iteration', 'getUpcomingMilestonesByProjectIds() returns the right milestone');
$t->is($upcoming_milestones[1]->title, 'first iteration', 'getUpcomingMilestonesByProjectIds() returns the right milestone');
$t->is($upcoming_milestones[1]->project_id, 2, 'getUpcomingMilestonesByProjectIds() returns the right milestone');
