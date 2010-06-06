<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->
  get('/')->
  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->

  click('#1')->
  click('My log time report')->

  with('response')->begin()->
    checkElement('td:contains("'.date('Y-m-d', strtotime("-2 days GMT")).'")')->
    checkElement('td:contains("12.0 hours")')->
  end()

;