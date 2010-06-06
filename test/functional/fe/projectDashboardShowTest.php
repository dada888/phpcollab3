<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->
  get('/')->

  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->

  followRedirect()->

  click('Projects')->

  click('Il mio terzo progetto')->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'show')->
    isParameter('id', '3')->
  end()->
  
  with('response')->begin()->
    checkElement('h3:contains("Overview")')->
    checkElement('h1:contains("Il mio terzo progetto")')->
    checkElement('div:contains("Il terzo progetto creato con il plugin idProjectManagementPlugin")')->
  end();