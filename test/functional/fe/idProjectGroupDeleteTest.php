<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();

$browser->

get('/')->

click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->

  click('Groups')->

  with('response')->begin()->
    checkElement('tr', 5)->
  end()->

  click('Delete', array(), array('position' => 2))->

 followRedirect()->

  with('response')->begin()->
    checkElement('tr', 4)->
  end()
;
