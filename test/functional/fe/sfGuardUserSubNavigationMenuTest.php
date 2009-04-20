<?php
include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();


$browser->
  get('/en/sfGuardUser')->
  click('Signin')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Users')->

  with('response')->begin()->
    isStatusCode(200)->

    checkElement('div.secondary-navigation ul li a[href="/index.php/en/sfGuardUser/new"]', 'Create new user')->
    checkElement('div.secondary-navigation ul li a[href="/index.php/en/sfGuardUser"]', 'User list')->

  end();