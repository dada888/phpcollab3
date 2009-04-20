<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();

$browser->

get('/')->

click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->

  click('Priorities')->

  with('response')->begin()->
    checkElement('tr', 2)->
  end()->

  click('Delete')->

 followRedirect()->

  responseContains('No Results')
;
