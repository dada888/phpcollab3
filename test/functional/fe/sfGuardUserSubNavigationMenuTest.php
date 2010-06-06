<?php
include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->
  get('/en/sfGuardUser')->
  click('Signin')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Users')->
  
  with('response')->begin()->
    isStatusCode(200)->

    checkElement('.secondary-navigation ul li a[href="/index.php/en/sfGuardUser/new"]', 'Create new user')->
    checkElement('.secondary-navigation ul li a[href*="/idUsers"]', 'Users list')->

  end();