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
    checkElement('table.table tr', 7)->
  end()->

  click('Edit')->

  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'edit')->
  end()->

  click('Delete')->

  followRedirect()->

  click('Last')->
  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('table.table tr', 6)->
  end()
;