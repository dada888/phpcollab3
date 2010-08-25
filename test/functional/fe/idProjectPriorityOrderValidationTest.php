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
  with('response')->begin()->
    checkElement('body:contains("Some error occurred processing your request.")')->
  end()->
  
  get('/en/idPriority/order', array('priority' => array('38'=>'2','1')), array('method' => 'POST'))->
  with('response')->begin()->
    checkElement('body:contains("Some error occurred processing your request.")')->
  end()->

  get('/en/idPriority/order', array('priority' => array()), array('method' => 'POST'))->
  with('response')->begin()->
    checkElement('body:contains("Invalid request")')->
  end()->

  get('/en/idPriority')->

  post('/en/idPriority/orderPriority', array('casa'=>'2','1'))->
  followRedirect()->

  with('response')->begin()->
    checkElement('body:contains("Some error occurred processing your request.")')->
  end()->

  post('/en/idPriority/orderPriority', array('move'=>'pippi','position' => '33'))->
  followRedirect()->

  with('response')->begin()->
    checkElement('body:contains("Some error occurred processing your request.")')->
  end()->

  post('/en/idPriority/orderPriority', array())->
  followRedirect()->
  with('response')->begin()->
    checkElement('body:contains("Some error occurred processing your request.")')->
  end()

;
