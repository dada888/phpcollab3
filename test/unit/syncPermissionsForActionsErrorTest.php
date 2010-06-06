<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
$database_manager = new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures_permission_unittest.yml');

$t = new lime_test(4, new lime_output_color());

$searchTask = new syncPermissionsForActions(new sfEventDispatcher(), new sfFormatter());
$searchTask->run(array(), array('--filenameFormat=permissions-error.yml --env=unittest --application=fe'));

$permissions = Doctrine::getTable('sfGuardPermission')->findAll(Doctrine::HYDRATE_ARRAY);
$t->is(count($permissions), 2, 'syncTask didn\'t delete to the table permission the new permissions.');

$searchTask->run(array(), array('--filenameFormat=permissions-format-error1.yml --env=unittest --application=fe'));
$t->is(count($permissions), 2, 'searchTask didn\'t add the new permissions with error in permission name format.');

$searchTask->run(array(), array('--filenameFormat=permissions-format-error2.yml --env=unittest --application=fe'));
$t->is(count($permissions), 2, 'searchTask didn\'t add the new permissions with error in permission name format.');

$searchTask->run(array(), array('--filenameFormat=permissions-format-error3.yml --env=unittest --application=fe'));
$t->is(count($permissions), 2, 'searchTask didn\'t add the new permissions with error in permission name format.');
