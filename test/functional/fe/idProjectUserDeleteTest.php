<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/')->

click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->

  click('Settings')->
  click('Last')->
  with('response')->begin()->
    checkElement('ul.action li.icon-group', 3)->
  end()->

  click('Delete', array(), array('position' => 2))->

 followRedirect()->

 click('Last')->

  with('response')->begin()->
    checkElement('ul.action li.icon-group', 2)->
  end()
;
