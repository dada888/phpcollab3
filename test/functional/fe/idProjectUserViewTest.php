<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();


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

    checkElement('#block-tables table.table th a[href="/index.php/en/sfGuardUser?sort=username&sort_type=asc"]', 'Username')->
    checkElement('#block-tables table.table th a[href="/index.php/en/sfGuardUser?sort=first_name&sort_type=asc"]',"First name")->
    checkElement('#block-tables table.table th a[href="/index.php/en/sfGuardUser?sort=last_name&sort_type=asc"]', "Last name")->
    checkElement('#block-tables table.table th a[href="/index.php/en/sfGuardUser?sort=email&sort_type=asc"]', "Email")->
    checkElement('#block-tables table.table th a[href="/index.php/en/sfGuardUser?sort=created_at&sort_type=asc"]', "Created at")->

    //checkElement('#block-forms div.right input[type="text"][id="sf_guard_user_filters[first_name]"]')->
    //checkElement('#block-forms div.right input[type="text"][id="sf_guard_user_filters[last_name]"]')->
    //checkElement('#block-forms div.right input[type="text"][id="sf_guard_user_filters[email]"]')->

    checkElement('input[type="text"][id="sf_guard_user_filters_username"]')->
    checkElement('select[id="sf_guard_user_filters_is_active"]')->
    checkElement('select[id="sf_guard_user_filters_groups_list"]')->
    checkElement('select[id="sf_guard_user_filters_permissions_list"]')->

    checkElement('input[type="submit"][value="Filter"]')->
end();
