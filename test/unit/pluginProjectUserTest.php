<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');

$t = new lime_test(4, new lime_output_color());

$role = ProjectUser::getRoleByUserIdAndProjectId(1, 1);
$t->is($role, false);

$role = ProjectUser::getRoleByUserIdAndProjectId(8, 3);
$t->is($role, 'customer');

$role = ProjectUser::getRoleByUserIdAndProjectId(7, 1);
$t->is($role, 'project manager');

$role = ProjectUser::getRoleByUserIdAndProjectId(3, 3);
$t->is($role, 'developer');
