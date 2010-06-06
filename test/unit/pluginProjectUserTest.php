<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');

$t = new lime_test(4, new lime_output_color());

$role = ProjectUser::getRoleByProfileIdAndProjectId(1, 1);
$t->is($role, false);

$role = ProjectUser::getRoleByProfileIdAndProjectId(8, 3);
$t->is($role, ProjectUser::$roles['customer']);

$role = ProjectUser::getRoleByProfileIdAndProjectId(7, 1);
$t->is($role, ProjectUser::$roles['project manager']);

$role = ProjectUser::getRoleByProfileIdAndProjectId(3, 3);
$t->is($role, ProjectUser::$roles['developer']);
