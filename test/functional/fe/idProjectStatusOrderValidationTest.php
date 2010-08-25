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
  with('response')->begin()->
    checkElement('body:contains("Some error occurred processing your request.")')->
  end()->

  get('/en/idStatus/order', array('status' => array('38'=>'2','1')), array('method' => 'POST'))->

  with('response')->begin()->
    checkElement('body:contains("Some error occurred processing your request.")')->
  end()->

  get('/en/idStatus/order', array('status' => array()), array('method' => 'POST'))->
  with('response')->begin()->
    checkElement('body:contains("Invalid request")')->
  end()->

  get('/en/idStatus')->

  post('/en/idStatus/orderStatus', array('casa'=>'2','1'))->
  followRedirect()->

  with('response')->begin()->
    checkElement('body:contains("Some error occurred processing your request.")')->
  end()->

  post('/en/idStatus/orderStatus', array('move'=>'pippi','position' => '33'))->
  followRedirect()->

  with('response')->begin()->
    checkElement('body:contains("Some error occurred processing your request.")')->
  end()->

  post('/en/idStatus/orderStatus', array())->
  followRedirect()->
  with('response')->begin()->
    checkElement('body:contains("Some error occurred processing your request.")')->
  end()

;
