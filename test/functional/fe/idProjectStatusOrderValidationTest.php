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
