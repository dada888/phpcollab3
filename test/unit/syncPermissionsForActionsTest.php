<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
$database_manager = new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures_permission_unittest.yml');

$t = new lime_test(7, new lime_output_color());

$searchTask = new searchPermissionsForActions(new sfEventDispatcher(), new sfFormatter());
$searchTask->run(array(), array('--dir=test/fixtures/ --env=unittest --application=fe'));

$permissions = Doctrine::getTable('sfGuardPermission')->findAll(Doctrine::HYDRATE_ARRAY);
$t->is(count($permissions), 6, 'searchTask added to the table permission the right number of new permissions.');

$searchTask->run(array(), array('--dir=test/fixtures/ --env=unittest --application=fe'));
$permissions = Doctrine::getTable('sfGuardPermission')->findAll(Doctrine::HYDRATE_ARRAY);
$t->is(count($permissions), 6, 'searchTask do not add already present permissions.');

$searchTask = new syncPermissionsForActions(new sfEventDispatcher(), new sfFormatter());
$searchTask->run(array(), array('--env=unittest --application=fe --filenameFormat=permissions-delete.yml'));

$permissions = Doctrine::getTable('sfGuardPermission')->findAll(Doctrine::HYDRATE_ARRAY);
$t->is(count($permissions), 4, 'syncTask delete the right number of permissions.');

$known_permissions = array('admin', 'user', 'module-Read', 'module-Create');

foreach ($permissions as $key => $permission)
{
  $t->is($permission['name'] , $known_permissions[$key], 'syncTask deleted the right permission.');
}