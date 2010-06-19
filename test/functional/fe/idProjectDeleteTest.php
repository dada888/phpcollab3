<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/en/idProject/edit/1')->

click('Login', array('signin' => array('username' => 'nouser', 'password' => 'nouser')))->

  with('request')->begin()->
    isParameter('module', 'sfGuardAuth')->
    isParameter('action', 'signin')->
  end()->

get('/en/idProject/edit/1')->
click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
  followRedirect()->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

click('Logout')->

followRedirect()->

get('/en/idProject/delete/1')->

click('Login', array('signin' => array('username' => 'nouser', 'password' => 'nouser')))->

  with('request')->begin()->
    isParameter('module', 'sfGuardAuth')->
    isParameter('action', 'signin')->
  end()->

click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
  followRedirect()->
  get('/en/idProject/delete/1')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  click('Projects')->
  with('response')->begin()->
    checkElement('a[href="/en/idProject/delete/1"]', false)->
  end()->

click('Dashboard')->
click('Logout')->

followRedirect()->

click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->

  click('Projects')->

  with('response')->begin()->
  isStatusCode(200)->

  checkElement('#project h3', 20)->
  end();

$browser->
  info('Delete a project')->
  get('/en/idProject/delete/1')->
  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'delete')->
  end()->

  followRedirect()->

  with('response')->begin()->
    checkElement('#project h3:contains("Il mio primo progetto")', false)->
    checkElement('#project h3', 16)->
  end()
;
