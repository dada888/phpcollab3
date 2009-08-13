<?php


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('fe', 'demo', false);
sfContext::createInstance($configuration)->dispatch();
