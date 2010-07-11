<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->
  get('/')->
  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->

  click('new issue')->
  click('My log time report')->

  with('response')->begin()->
    checkElement('ul li:contains("'.date('F d Y', strtotime("-2 days")).'")')->
    checkElement('ul li:contains("12.0")')->
  end()

;