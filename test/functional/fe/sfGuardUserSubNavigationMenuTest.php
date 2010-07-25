<?php
include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->
  get('/en/sfGuardUser')->
  click('Signin')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Settings')->
  click('Users')->
  
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('a[href="/index.php/en/sfGuardUser/new"]', 'Add')->
  end();