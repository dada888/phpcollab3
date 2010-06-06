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

  get('/en/idStatus/order', array('status' => array('casa'=>'2','1')), array('method' => 'POST'))->

  responseContains('Some error occurred processing your request.')->

  get('/en/idStatus/order', array('status' => array('38'=>'2','1')), array('method' => 'POST'))->

  responseContains('Some error occurred processing your request.')->

  get('/en/idStatus/order', array('status' => array()), array('method' => 'POST'))->

  responseContains('Invalid request')->

  get('/en/idStatus')->

  post('/en/idStatus/orderStatus', array('casa'=>'2','1'))->
  followRedirect()->

  responseContains('Some error occurred processing your request.')->

  post('/en/idStatus/orderStatus', array('move'=>'pippi','position' => '33'))->
  followRedirect()->

  responseContains('Some error occurred processing your request.')->

  post('/en/idStatus/orderStatus', array())->
  followRedirect()->
  responseContains('Some error occurred processing your request.')

;
