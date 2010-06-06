<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/')->

click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->
  get('/en/idProject/show/3')->

  click('Issues')->

  responseContains('new issue 2')->

  click('Delete', array(), array('position' => 2))->

 followRedirect()->

 with('response')->begin()->
    checkElement('tr:contains("new issue 2")', false)->
  end()
;
