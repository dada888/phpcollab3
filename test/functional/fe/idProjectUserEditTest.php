<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();



  $browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->
  
  click('Users')->

  click('nopuser')->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'edit')->
  end()->

  setField('sf_guard_user[username]', 'nopuser')->
  setField('sf_guard_user[password]', 'mario')->
  setField('sf_guard_user[password_again]', 'mario')->
  setField('sf_guard_user[first_name]', 'mario')->
  setField('sf_guard_user[last_name]', 'mariotti')->
  setField('sf_guard_user[email_address]', 'mariotti@example.com')->
  setField('sf_guard_user[is_active]', 'on')->
  click('Save')->
  
  with('form')->begin()->
    hasErrors(false)->
  end()->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'edit')->
  end()->
  click('Users')->
  with('response')->begin()->
    checkElement('ul li:contains("mariotti@example.com")')->
    checkElement('ul li:contains("mariotti")')->
    checkElement('ul li:contains("mario")')->
  end();
  
;
