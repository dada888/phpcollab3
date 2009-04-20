<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();


$browser->

get('/en/idProject/show/3')->
click('Login', array('signin' => array('username' => 'nopuser', 'password' => 'nopuser')))->
  followRedirect()->
  with('response')->begin()->
    isStatusCode('403')->
  end()->
click('Logout')->


get('/en/idProject/show/3')->
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

  responseContains('Il terzo progetto creato')
;