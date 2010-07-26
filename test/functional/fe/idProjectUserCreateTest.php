<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();



$browser->

  get('/settings')->
  with('response')->begin()->
      isStatusCode(404)->
  end()->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->
  
  click('Settings')->
  click('Users')->

  click('Add')->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'new')->
  end()->

  with('response')->begin()->
    checkElement('input[type="text"][id="sf_guard_user_username"]')->
    checkElement('input[type="password"][id="sf_guard_user_password"]')->
    checkElement('input[type="password"][id="sf_guard_user_password_again"]')->

    checkElement('input[type="text"][id="sf_guard_user_Profile_first_name"]')->
    checkElement('input[type="text"][id="sf_guard_user_Profile_last_name"]')->
    checkElement('input[type="text"][id="sf_guard_user_Profile_email"]')->
    checkElement('input[type="checkbox"][id="sf_guard_user_is_active"]')->
    checkElement('input[type="checkbox"][id="sf_guard_user_is_super_admin"]')->
    checkElement('select[id="sf_guard_user_groups_list"]', false)->
    checkElement('select[id="sf_guard_user_permissions_list"]', false)->
  end()->
  
  setField('sf_guard_user[username]', 'brigdo')->
  setField('sf_guard_user[password]', 'brigdo')->
  setField('sf_guard_user[password_again]', 'brigdo')->
  setField('sf_guard_user[Profile][first_name]', 'blablu')->
  setField('sf_guard_user[Profile][last_name]', 'bubbo')->
  setField('sf_guard_user[Profile][email]', 'bri@example.com')->
  setField('sf_guard_user[is_active]', 'on')->
  click('Save')->
  with('form')->begin()->
    hasErrors(false)->
  end()->
  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'create')->
  end()->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'edit')->
    isParameter('id', '9')->
  end()->
  click('Users')->
  click('Last')->
  with('response')->begin()->
    checkElement('ul li:contains("brigdo")')->
  end();