<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();

$browser->

get('/en/idProject/show/1')->
click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
  followRedirect()->
  with('response')->begin()->
    isStatusCode('404')->
  end()->

get('/')->

click('Logout')->

get('/')->
click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  get('/en/idProject/show/1')->
  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'show')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->

    checkElement('th:contains("Id")')->
    checkElement('th:contains("Name")')->
    checkElement('th:contains("Description")')->
    checkElement('th:contains("Public")')->
    checkElement('th:contains("Created at")')->
    checkElement('th:contains("Updated at")')->

    checkElement('td:contains("1")')->
    checkElement('td:contains("Il mio primo progetto")')->
    checkElement('td:contains("Il primo progetto creato con il plugin idProjectManagmentPlugin")')->
    checkElement('td:contains("Private")')->
    checkElement('td:contains("'.date("Y-m-d", strtotime("-1 day")).'")')->
    checkElement('td:contains("'.date("Y-m-d", strtotime("-1 hours")).'")')->

  end()
;