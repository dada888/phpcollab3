<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();



  $browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Projects')->
  
  click('Il mio terzo progetto')->

  click('Users')->
  click('puser')->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'edit')->
    isParameter('id', '3')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
  end()->

  click('Users')->
  click('puser')->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'edit')->
    isParameter('id', '3')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
  end()->

  click('Dashboard')->

  click('Logout')->

  followRedirect()->

  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->

  click('Projects')->

  click('Il mio terzo progetto')->
  
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('a[href="/index.php/en/sfGuardUser/3/edit"]', false)->
    checkElement('a:contains("Users")', false)->
  end()->

  get('/index.php/en/sfGuardUser/3/edit')->

  with('response')->begin()->
    isStatusCode(403)->
  end()

;
