<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

get('/')->
click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
followRedirect()->
get('/en/idStatus')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

click('Logout')->

  get('/en/idStatus')->
  with('response')->begin()->
      isStatusCode(401)->
  end()->

  click('Signin')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Settings')->
  click('Statuses')->

  with('request')->begin()->
    isParameter('module', 'idStatus')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    
    checkElement('a[href="/index.php/en/idStatus/new"]', 'Add')->

    checkElement('table.table th:contains("Id")')->
    checkElement('table.table th:contains("Name")')->
    checkElement('table.table th:contains("Status type")')->

    checkElement('table.table td a[href="/index.php/en/idStatus/edit/1"]')->
    checkElement('table.table td:contains("new")', 2)->
end();
