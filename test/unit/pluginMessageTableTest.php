<?php
include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');


$message_query = Doctrine::getTable('Message')->getQueryForProjectMessages(2);
$results = $message_query->execute();

$t = new lime_test(2, new lime_output_color());

$t->ok($message_query instanceof Doctrine_query, 'retrieveQueryForProjectMessages returns a Doctrine_Query instance');
$t->is(count($results), 2, 'retrieveQueryForProjectessages returns the right Doctrine_Query instance');
