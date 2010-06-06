<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

  $browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->

  followRedirect()->
  
  click('puser')->

  with('request')->begin()->
    isParameter('module', 'idProfile')->
    isParameter('action', 'edit')->
  end()->

  with('response')->begin()->
    checkElement('label:contains("Is active")', false)->
    checkElement('label:contains("Is super admin")', false)->
    checkElement('label:contains("Groups")', false)->
    checkElement('label:contains("Permissions")', false)->
  end()->

  click('Save', array('sf_guard_user' => array('password' => 'mario2',
                                               'password_again' => 'mario2',
                                               'Profile' => array('first_name' => 'mariotto',
                                                                  'last_name' => 'mariotti',
                                                                  'email' => 'mariotti@examople.com'
  ))))->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idProfile')->
    isParameter('action', 'index')->
  end()->
  responseContains('mariotto')
  
;
