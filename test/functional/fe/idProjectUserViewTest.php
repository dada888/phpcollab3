<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

get('/')->
click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
followRedirect()->
get('/settings')->
  with('response')->begin()->
    isStatusCode(404)->
  end()->
get('/')->
click('Logout')->

get('/settings')->
with('response')->begin()->
    isStatusCode(404)->
end()->
get('/')->

click('Signin')->
click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
followRedirect()->

click('Settings')->
click('Users')->

with('request')->begin()->
  isParameter('module', 'sfGuardUser')->
  isParameter('action', 'index')->
end()->

with('response')->begin()->
  isStatusCode(200)->

  checkElement('a[href*="sort=s.username&sort_type=asc"]', '/Username/')->
  checkElement('a[href*="sort=s.first_name&sort_type=asc"]',"/First Name/")->
  checkElement('a[href*="sort=s.last_name&sort_type=asc"]', "/Last Name/")->

  checkElement('input[type="text"][id="sf_guard_user_filters_username"]')->
  checkElement('input[type="submit"][value="Filter"]')->
end()
;