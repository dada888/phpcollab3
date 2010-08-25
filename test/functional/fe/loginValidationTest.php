<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());

$browser->
  get('/')->

  click('Login', array('signin' => array('username' => '', 'password' => '')))->
  with('response')->begin()->
    checkElement('body:contains("The username and/or password is invalid.")')->
  end()->

  click('Login', array('signin' => array('username' => 'nouser', 'password' => 'nouser')))->
  with('response')->begin()->
    checkElement('body:contains("The username and/or password is invalid.")')->
  end()->

  click('Login', array('signin' => array('username' => 'nouser', 'password' => '')))->
  with('response')->begin()->
    checkElement('body:contains("The username and/or password is invalid.")')->
  end()->
  
  click('Login', array('signin' => array('username' => '', 'password' => 'nouser')))->
  with('response')->begin()->
    checkElement('body:contains("The username and/or password is invalid.")')->
  end()->
  
  click('Login', array('signin' => array('username' => '', 'password' => 'nouser', 'remember' => '12')))->
  with('response')->begin()->
    checkElement('body:contains("Invalid.")')->
  end()->

  click('Login', array('signin' => array('username' => '', 'password' => 'nouser', 'remember' => '-1')))->
  with('response')->begin()->
    checkElement('body:contains("Invalid.")')->
  end()->

  click('Login', array('signin' => array('username' => 'my', 'password' => 'nouser', 'extra_field' => 'extra')))->
  with('response')->begin()->
    checkElement('body:contains("Unexpected extra form field")')->
  end()
;