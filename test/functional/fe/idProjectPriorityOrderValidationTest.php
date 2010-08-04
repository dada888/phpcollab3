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

  get('/en/idPriority/order', array('priority' => array('casa'=>'2','1')), array('method' => 'POST'))->

  responseContains('Some error occurred processing your request.')->

  get('/en/idPriority/order', array('priority' => array('38'=>'2','1')), array('method' => 'POST'))->

  responseContains('Some error occurred processing your request.')->

  get('/en/idPriority/order', array('priority' => array()), array('method' => 'POST'))->

  responseContains('Invalid request')->

  get('/en/idPriority')->

  post('/en/idPriority/orderPriority', array('casa'=>'2','1'))->
  followRedirect()->

  responseContains('Some error occurred processing your request.')->

  post('/en/idPriority/orderPriority', array('move'=>'pippi','position' => '33'))->
  followRedirect()->

  responseContains('Some error occurred processing your request.')->

  post('/en/idPriority/orderPriority', array())->
  followRedirect()->
  responseContains('Some error occurred processing your request.')

;
