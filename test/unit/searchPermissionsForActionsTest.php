<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
$database_manager = new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures_permission_unittest.yml');

$t = new lime_test(3, new lime_output_color());

$searchTask = new searchPermissionsForActions(new sfEventDispatcher(), new sfFormatter());
$searchTask->run(array(), array('--dir=test/fixtures/ --env=unittest --application=fe'));

$permissions = Doctrine::getTable('sfGuardPermission')->findAll(Doctrine::HYDRATE_ARRAY);
$t->is(count($permissions), 6, 'searchTask added to the table permission the right number of new permissions.');

$searchTask->run(array(), array('--dir=test/fixtures/ --env=unittest --application=fe'));
$permissions = Doctrine::getTable('sfGuardPermission')->findAll(Doctrine::HYDRATE_ARRAY);
$t->is(count($permissions), 6, 'searchTask do not add already present permissions.');

$t->info('Check if admin group has the right number of permission at the end');

$sggroup_admin = Doctrine::getTable('sfGuardGroup')
                            ->createQuery()
                            ->from('sfGuardGroup sgg')
                            ->where('sgg.name = ?', 'admin')
                            ->fetchOne();

$t->is(count($sggroup_admin->getPermissions()), 5, 'admin group has admin permission and the other four new permissions');
