<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');

$project4 = Doctrine::getTable('Project')->find(array(4));
$project2 = Doctrine::getTable('Project')->find(array(2));

$t = new lime_test(4, new lime_output_color());

$t->is($project4->hasRoadmap(), false, 'hasRoadmap() returns false for project 4');
$t->is($project2->hasRoadmap(), true, 'hasRoadmap() returns true for project 2');

$t->ok($project2->isOnBudget(), 'project 2 is on budget');
$t->ok(!$project4->isOnBudget(), 'project 4 is not on budget');
