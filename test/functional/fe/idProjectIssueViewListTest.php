<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'index')->
  end()->

  click('3')->

  click('Issues')->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode('200')->

    checkElement('th:contains("Id")')->
    checkElement('th:contains("Title")')->
    checkElement('th:contains("Description")')->
    checkElement('th:contains("Starting date")')->
    checkElement('th:contains("Ending date")')->
    checkElement('th:contains("Status")')->
    checkElement('th:contains("Priority")')->
  end()
;
