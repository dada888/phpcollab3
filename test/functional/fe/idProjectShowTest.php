<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/en/idProject/show/5')->
click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
  followRedirect()->
  with('response')->begin()->
    isStatusCode('404')->
  end()->

get('/')->

click('Logout')->

get('/en/idProject/show/3')->
click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'show')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body:contains("Il mio terzo progetto")')->
    checkElement('body:contains("Il terzo progetto creato con il plugin idProjectManagementPlugin")')->
  end()->

  click('Dashboard')->
  click('Logout')->
  followRedirect()->

  click('Login', array('signin' => array('username' => 'pmanager', 'password' => 'pmanager')))->
  followRedirect()->

  click('Projects')->
  click('Il mio primo progetto')->

  with('response')->begin()->
    checkElement('a[href~="idProject/1/show/Gantt"]', '/Gantt chart/')->
  end()->

  click('Dashboard')->

  click('Logout')->

  get('/en/idProject/show/5')->
  click('Login', array('signin' => array('username' => 'pmanager', 'password' => 'pmanager')))->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'show')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->

    //checkElement('td.green','/Estimated time : 136.0 hours - Log time: 15.0 hours/')->

  end()->

  get('/en/idProject/show/1')->
  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'show')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->

    //checkElement('td.green','/Estimated time : 510.0 hours - Log time: 237.5 hours/')->

  end()

;