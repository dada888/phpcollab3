<?php
include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->
  get('/en/sfGuardGroup')->
  click('Signin')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->
  
  //click('Groups')->
  get('/en/sfGuardGroup')->

  with('response')->begin()->
    isStatusCode(200)->

    checkElement('div#block-tables div.secondary-navigation ul li a[href="/index.php/en/sfGuardGroup/new"]', 'Create new group')->
    checkElement('div#block-tables div.secondary-navigation ul li a[href="/index.php/en/sfGuardGroup"]', 'Groups list')->

  end();