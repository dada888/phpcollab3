<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();


$browser->

get('/')->
click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
followRedirect()->
get('/en/idPriority')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

click('Logout')->

  get('/en/idPriority')->
  with('response')->begin()->
      isStatusCode(401)->
  end()->

  click('Signin')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Priorities')->

  with('request')->begin()->
    isParameter('module', 'idPriority')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    
    checkElement('div#block-tables div.secondary-navigation ul li a[href="/index.php/en/idPriority/new"]', 'Create new priority')->

    checkElement('#block-tables table.table th:contains("Id")')->
    checkElement('#block-tables table.table th:contains("Name")')->

    checkElement('#block-tables table.table td a[href="/index.php/en/idPriority/edit/1"]')->
    checkElement('#block-tables table.table td:contains("normal")')->
end();
