<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());

$browser->inizilizeDatabase();

$browser->
  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  with('response')->begin()->
    isStatusCode(200)->
    
    checkElement('div#main-navigation ul li a[href="/index.php/"]', 'Home')->
    checkElement('div#main-navigation ul li a[href="/index.php/en/idProject"]', 'Projects')->
    checkElement('div#main-navigation ul li a[href="/index.php/en/sfGuardUser"]', 'Users')->
    checkElement('div#main-navigation ul li a[href="/index.php/en/sfGuardGroup"]', 'Groups')->
    checkElement('div#main-navigation ul li a[href="/index.php/en/sfGuardPermission"]', 'Permissions')->

    checkElement('div#user-navigation ul li a[href="/index.php/en/logout"]', 'Logout')->

  end();