<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
$database_manager = new sfDatabaseManager($configuration);

$t = new lime_test(9, new lime_output_color());

$t->is(Doctrine::getTable('Status')->retrieveHighestPosition(), -1, '->retrieveHighestPosition() returns the rigth value');

Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');

$sql = "SELECT s.id AS s__id, s.name AS s__name, s.status_type AS s__status_type, s.position AS s__position FROM status s ORDER BY s.position";
$query = Doctrine::getTable('Status')->getStatusesOrderByPositionQuery();
$t->ok($query instanceof Doctrine_Query, '->getStatusesOrderByPositionQuery() returns the right object');
$t->is($query->getSqlQuery(), $sql, '->getStatusesOrderByPositionQuery() makes the right query');

$t->is(Doctrine::getTable('Status')->isClosedTypeById(3), true, '->isClosedTypeById(3) returns the rigth value');
$t->is(Doctrine::getTable('Status')->isClosedTypeById(2), true, '->isClosedTypeById(3) returns the rigth value');
$t->is(Doctrine::getTable('Status')->isClosedTypeById(1), false, '->isClosedTypeById(1) returns the rigth value');

$t->is(Doctrine::getTable('Status')->isOpenTypeById(1), true, '->isClosedTypeById(1) returns the rigth value');
$t->is(Doctrine::getTable('Status')->isOpenTypeById(2), false, '->isClosedTypeById(1) returns the rigth value');
$t->is(Doctrine::getTable('Status')->isOpenTypeById(3), false, '->isClosedTypeById(3) returns the rigth value');
