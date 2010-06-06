<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/')->

click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->

  get('/en/sfGuardGroup')->

  with('response')->begin()->
    checkElement('tr', 8)->
  end()->

  click('Delete', array(), array('position' => 2))->

 followRedirect()->

  with('response')->begin()->
    checkElement('tr', 7)->
  end()
;
