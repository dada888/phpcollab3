<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Time')->
  click('Last')->

  with('response')->begin()->
    checkElement('ul.action > li', 5)->
  end()->

  click('Delete')->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('ul.action > li', 4)->
  end()
;