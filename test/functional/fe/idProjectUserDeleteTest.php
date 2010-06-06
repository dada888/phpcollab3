<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/')->

click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->

  click('Users')->

  with('response')->begin()->
    checkElement('tr', 9)->
  end()->

  click('Delete', array(), array('position' => 3))->

 followRedirect()->

 click('Last')->

  with('response')->begin()->
    checkElement('tr', 6)->
  end()
;
