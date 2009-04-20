<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());

$browser->
  get('/')->

  click('Login', array('signin' => array('username' => '', 'password' => '')))->
  responseContains('Required. The username and/or password is invalid.')->

  click('Login', array('signin' => array('username' => 'nouser', 'password' => 'nouser')))->
  responseContains('The username and/or password is invalid.')->

  click('Login', array('signin' => array('username' => 'nouser', 'password' => '')))->
  responseContains('The username and/or password is invalid.')->

  click('Login', array('signin' => array('username' => '', 'password' => 'nouser')))->
  responseContains('The username and/or password is invalid.')->
  
  click('Login', array('signin' => array('username' => '', 'password' => 'nouser', 'remember' => '12')))->
  responseContains('Invalid.')->

  click('Login', array('signin' => array('username' => '', 'password' => 'nouser', 'remember' => '-1')))->
  responseContains('Invalid.')

;