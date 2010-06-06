<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');

$profile = Doctrine::getTable('Profile')->find(array(1));

$t = new lime_test(1, new lime_output_color());

$t->is($profile->getName(), 'Amministro (admin) Amministroni [amministro@example.com]', '__toString() returns the right value');
