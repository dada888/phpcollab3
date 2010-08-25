<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

get('/en/idProject/show/3')->
click('Login', array('signin' => array('username' => 'nopuser', 'password' => 'nopuser')))->
  followRedirect()->
  with('response')->begin()->
    isStatusCode('404')->
  end()->
get('/')->
click('Logout')->


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
  with('response')->begin()->
    isStatusCode('200')->
  end()->
  with('response')->begin()->
    checkElement('body:contains("Il terzo progetto creato")')->
  end()->

  with('response')->begin()->
    checkElement('a[href="/index.php/en/idProject/edit/3"]', false)->
    checkElement('a[href="/index.php/en/idProject/delete/3"]', false)->
  end()->

  get('/index.php/en/idProject/delete/3')->
  with('response')->begin()->
    isStatusCode(403)->
  end()
;