<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

get('/')->
click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
followRedirect()->

get('/en/sfGuardGroup')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

click('Logout')->

  get('/en/sfGuardGroup')->
  with('response')->begin()->
      isStatusCode(401)->
  end()->

  click('Signin')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  //click('Groups')->
  get('/en/sfGuardGroup')->

  with('request')->begin()->
    isParameter('module', 'sfGuardGroup')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->

    checkElement('div#block-tables div.content h2', 'Groups list')->
    
    checkElement('#block-tables table.table th a[href="/index.php/en/sfGuardGroup?sort=name&sort_type=asc"]', 'Name')->
    checkElement('#block-tables table.table th a[href="/index.php/en/sfGuardGroup?sort=description&sort_type=asc"]',"Description")->
    checkElement('#block-tables table.table tr th:contains("Actions")')->

    checkElement('input[type="text"][id="sf_guard_group_filters_name"]')->
    checkElement('input[type="text"][id="sf_guard_group_filters_description"]')->
    
    checkElement('input[type="submit"][value="Filter"]')->

    checkElement('th a:contains("Created at")', false)->
    checkElement('th a:contains("Updated at")', false)->
    checkElement('label:contains("Created at")', false)->
    checkElement('label:contains("Updated at")', false)->
    checkElement('label:contains("Groups list")', false)->
    checkElement('label:contains("Users list")', false)->

end();
