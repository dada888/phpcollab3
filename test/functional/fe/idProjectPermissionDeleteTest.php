<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/')->

click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->

  //click('Permissions')->
  get('/en/sfGuardPermission')->

  responseContains('44 results')->

  click('Delete', array(), array('position' => 2))->

 followRedirect()->

  responseContains('43 results')
;
