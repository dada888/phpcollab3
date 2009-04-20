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
    
    checkElement('div.secondary-navigation ul li a[href="/index.php/en/idProject/new"]', 'Create new project')->
    checkElement('div.secondary-navigation ul li a[href="/index.php/en/idProject"]', 'Projects list')->
    
  end();