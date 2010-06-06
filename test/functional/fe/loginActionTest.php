<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->
  get('/')->
  info('Login works correctly')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->
  

  with('request')->begin()->
    isParameter('module', 'idDashboard')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
  end()->

  info('Logout works correctly')->
  click('Logout')->
  with('response')->begin()->
    isStatusCode(302)->
  end()->
  followRedirect()->
  
  with('response')->begin()->
    isStatusCode(401)->
  end();

$browser->info('Login with remember works correctly')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin', 'remember' => true)))->
  
  with('request')->begin()->
    isParameter('action', 'signin')->
  end()->

  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'idDashboard')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
  end();

$browser->test()->ok($browser->getRequest()->getCookie('phpcollabRememberMe'), 'Remember cookie is ok');

$browser->
  info('referer is stored correctly')->
  click('Logout')->

  get('/en/idProject/show/1')->
  with('response')->begin()->
    isStatusCode(401)->
  end()->

  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'show')->
    isParameter('id', '1')->
  end()
;

