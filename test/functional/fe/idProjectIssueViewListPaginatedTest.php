<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->

  click('Projects')->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'index')->
  end()->

  click('Il mio terzo progetto')->

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
    checkElement('th:contains("Milestone")')->


    checkElement('tr td span', '1')->
    checkElement('tr td a[href="/index.php/en/idProject/3/idIssues?page=2"]', '2')->
    checkElement('tr td a[href="/index.php/en/idProject/3/idIssues?page=3"]', '3')->
    checkElement('tr td a[href="/index.php/en/idProject/3/idIssues?page=4"]', '4')->
    checkElement('tr td a[href="/index.php/en/idProject/3/idIssues?page=5"]', '5')->
  end()->

  get('/index.php/en/idProject/3/idIssues?page=2')->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'index')->
    isParameter('page', '2')->
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

    checkElement('tr td a[href="/index.php/en/idProject/3/idIssues?page=1"]', 3)->
    checkElement('tr td span', '2')->
    checkElement('tr td a[href="/index.php/en/idProject/3/idIssues?page=3"]', '3')->
    checkElement('tr td a[href="/index.php/en/idProject/3/idIssues?page=4"]', '4')->
    checkElement('tr td a[href="/index.php/en/idProject/3/idIssues?page=5"]', '5')->
  end()->


  get('/index.php/en/idProject/3/idIssues?page=7')->

  with('response')->begin()->
    checkElement('tr td:contains("third iteration")')->
  end()


;
