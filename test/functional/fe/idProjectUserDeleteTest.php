<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();

$browser->

get('/')->

click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->

  click('Users')->

  with('response')->begin()->
    checkElement('tr', 7)->
  end()->

  click('Delete', array(), array('position' => 3))->

 followRedirect()->

  with('response')->begin()->
    checkElement('tr', 6)->
  end()
;
