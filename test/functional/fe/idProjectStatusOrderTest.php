<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Settings')->
  click('Statuses')->

  post('/en/idStatus/order', array('status' => array('2','1','3')))->

  get('/en/idStatus')->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('table.table tr#status_2', true, array('position' => 1))->
    checkElement('table.table tr#status_1', true, array('position' => 9))->
    checkElement('table.table tr#status_3', true, array('position' => 17))->
  end()->

  post('/en/idStatus/order', array('status' => array('1','2')))->

  get('/en/idStatus')->
  with('request')->begin()->
    isParameter('module', 'idStatus')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('table.table tr#status_1', true, array('position' => 1))->
    checkElement('table.table tr#status_2', true, array('position' => 9))->
    checkElement('table.table tr#status_3', true, array('position' => 17))->
  end()->

  click('Up')->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idStatus')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('table.table tr#status_2', true, array('position' => 1))->
    checkElement('table.table tr#status_1', true, array('position' => 9))->
    checkElement('table.table tr#status_3', true, array('position' => 17))->
  end()->

  click('Down')->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idStatus')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('table.table tr#status_1', true, array('position' => 1))->
    checkElement('table.table tr#status_2', true, array('position' => 9))->
    checkElement('table.table tr#status_3', true, array('position' => 17))->
  end()

;