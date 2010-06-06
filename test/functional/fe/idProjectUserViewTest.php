<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

get('/')->
click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
followRedirect()->
get('/en/sfGuardUser')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

click('Logout')->

  get('/en/sfGuardUser')->
  with('response')->begin()->
      isStatusCode(401)->
  end()->

  click('Signin')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Users')->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    
    checkElement('div#block-tables div.secondary-navigation ul li:contains("Create new user")')->

    checkElement('table.table th a[href*="sort=s.username&sort_type=asc"]', '/Username/')->

    checkElement('table.table th a[href*="sort=p.first_name&sort_type=asc"]',"/First name/")->
    checkElement('table.table th a[href*="sort=p.last_name&sort_type=asc"]', "/Last name/")->
    checkElement('table.table th a[href*="sort=p.email&sort_type=asc"]', "/Email/")->
    checkElement('table.table th a[href*="sort=s.created_at&sort_type=asc"]', "/Created at/")->

    checkElement('input[type="text"][id="sf_guard_user_filters_username"]')->
    checkElement('select[id="sf_guard_user_filters_is_active"]')->
    checkElement('select[id="sf_guard_user_filters_groups_list"]')->
    checkElement('select[id="sf_guard_user_filters_permissions_list"]')->

    checkElement('input[type="submit"][value="Filter"]')->
  end()->

  with('response')->begin()->
    checkElement('#block-tables table.table tr', 7)->
    checkElement('table.table tr span:contains("1")')->
    checkElement('#block-tables table.table tr a[href*="idUsers?page=2"]', '/2/', array('position'=> 0))->
    checkElement('#block-tables table.table tr a[href*="idUsers?page=2"]', '/Next/', array('position'=> 1))->
    checkElement('#block-tables table.table tr a[href*="idUsers?page=2"]', '/Last/', array('position'=> 2))->
  end()->

  click('Next')->

  with('response')->begin()->
    checkElement('#block-tables table.table tr', 5)->
    checkElement('#block-tables table.table tr a[href*="idUsers?page=1"]', '/First/', array('position'=> 0))->
    checkElement('#block-tables table.table tr a[href*="idUsers?page=1"]', '/Prev/', array('position'=> 1))->
    checkElement('#block-tables table.table tr a[href*="idUsers?page=1"]', '/1/', array('position'=> 2))->
    checkElement('#block-tables table.table tr span:contains("2")')->
  end()

;