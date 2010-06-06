<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  //click('Statuses')->
  get('/en/idStatus')->

  with('request')->begin()->
    isParameter('module', 'idStatus')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('div#block-tables div.secondary-navigation ul li a[href="/index.php/en/idStatus/new"]', 'Create new status')->

    checkElement('#block-tables table.table th:contains("Id")')->
    checkElement('#block-tables table.table th:contains("Name")')->
    checkElement('#block-tables table.table th:contains("Status type")')->

    checkElement('#block-tables table.table td a[href="/index.php/en/idStatus/edit/1"]')->
    checkElement('#block-tables table.table td:contains("new")', 2)->
  end()->

  post('/en/idStatus/order', array('status' => array('2','1','3')))->

  get('/en/idStatus')->
//showPage()->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#block-tables table.table tr#status_2', true, array('position' => 1))->
    checkElement('#block-tables table.table tr#status_1', true, array('position' => 9))->
    checkElement('#block-tables table.table tr#status_3', true, array('position' => 17))->
  end()->

  post('/en/idStatus/order', array('status' => array('1','2')))->

  get('/en/idStatus')->
  with('request')->begin()->
    isParameter('module', 'idStatus')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#block-tables table.table tr#status_1', true, array('position' => 1))->
    checkElement('#block-tables table.table tr#status_2', true, array('position' => 9))->
    checkElement('#block-tables table.table tr#status_3', true, array('position' => 17))->
  end()->

  click('Up')->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idStatus')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#block-tables table.table tr#status_2', true, array('position' => 1))->
    checkElement('#block-tables table.table tr#status_1', true, array('position' => 9))->
    checkElement('#block-tables table.table tr#status_3', true, array('position' => 17))->
  end()->

  click('Down')->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idStatus')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#block-tables table.table tr#status_1', true, array('position' => 1))->
    checkElement('#block-tables table.table tr#status_2', true, array('position' => 9))->
    checkElement('#block-tables table.table tr#status_3', true, array('position' => 17))->
  end()

;