<?php
include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->
  get('/en/sfGuardPermission')->
  click('Signin')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  //click('Permissions')->
  get('/en/sfGuardPermission')->

  with('response')->begin()->
    isStatusCode(200)->

    checkElement('div.secondary-navigation ul li a[href="/index.php/en/sfGuardPermission/new"]', 'Create new permission')->
    checkElement('div.secondary-navigation ul li a[href="/index.php/en/sfGuardPermission"]', 'Permissions list')->

  end();