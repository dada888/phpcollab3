<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
$database_manager = new sfDatabaseManager($configuration);

$t = new lime_test(4, new lime_output_color());

$t->is(Doctrine::getTable('Priority')->retrieveHighestPosition(), -1, '->retrieveHighestPosition() returns the rigth value');

Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');

$sql = "SELECT p.id AS p__id, p.name AS p__name, p.position AS p__position FROM priority p ORDER BY p.position";
$query = Doctrine::getTable('Priority')->getPrioritiesOrderByPositionQuery();
$t->ok($query instanceof Doctrine_Query, '->getPrioritiesOrderByPositionQuery() returns the right object');
$t->is($query->getSqlQuery(), $sql, '->getPrioritiesOrderByPositionQuery() makes the right query');

$t->is(Doctrine::getTable('Priority')->retrieveHighestPosition(), 1, '->retrieveHighestPosition() returns the rigth value');