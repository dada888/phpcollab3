<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Settings')->
  click('Priorities')->

  with('request')->begin()->
    isParameter('module', 'idPriority')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('a[href="/index.php/en/idPriority/new"]', 'Add')->

    checkElement('table.table th:contains("Id")')->
    checkElement('table.table th:contains("Name")')->

    checkElement('table.table td a[href="/index.php/en/idPriority/edit/1"]')->
    checkElement('table.table td:contains("normal")')->
    checkElement('table.table td:contains("high")')->
  end()->

  get('/en/idPriority/order', array('priority' => array('2','1')), array('method' => 'POST'))->

  get('/en/idPriority')->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('table.table td', '2', array('position' => 1))->
    checkElement('table.table td', '1', array('position' => 8))->
  end()->

  click('Up')->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idPriority')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('table.table td', '1', array('position' => 1))->
    checkElement('table.table td', '2', array('position' => 8))->
  end()->

  click('Down')->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idPriority')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('table.table td', '2', array('position' => 1))->
    checkElement('table.table td', '1', array('position' => 8))->
  end()

;
