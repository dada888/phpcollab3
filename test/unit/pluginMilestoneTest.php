<?php
include(dirname(__FILE__).'/../bootstrap/unit.php');

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
$database_manager = new sfDatabaseManager($configuration);

$t = new lime_test(1, new lime_output_color());

$milestone = new Milestone();
$milestone->setTitle('milestone_title');

$t->is("".$milestone, 'milestone_title', '__toString() returns the right value');