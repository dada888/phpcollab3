<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/en/idProject/edit/1')->
click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
  followRedirect()->
  with('response')->begin()->
    isStatusCode('403')->
  end()->

click('Logout')->

get('/en/idProject/edit/1')->
click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->
  with('response')->begin()->
    isStatusCode('403')->
  end()->

click('Logout')->

get('/en/idProject/edit/3')->
click('Login', array('signin' => array('username' => 'nopuser', 'password' => 'nopuser')))->
  followRedirect()->
  with('response')->begin()->
    isStatusCode('403')->
  end()->

click('Logout')->


get('/en/idProject/edit/3')->
click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'edit')->
    isParameter('id', '3')->
  end()->

  with('response')->begin()->
    isStatusCode('403')->
  end();
