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

    checkElement('.menu div:contains("Id")')->
    checkElement('.menu div:contains("Name")')->
    checkElement('.menu div:contains("Tracker")')->
    checkElement('.menu div:contains("Status")')->
    checkElement('.menu div:contains("Priority")')->
    checkElement('.menu div:contains("Assigned To")')->


    checkElement('.pagenation ul li a[href="/index.php/en/idProject/3/idIssues?page=2"]', '2')->
    checkElement('.pagenation ul li a[href="/index.php/en/idProject/3/idIssues?page=3"]', '3')->
    checkElement('.pagenation ul li a[href="/index.php/en/idProject/3/idIssues?page=4"]', '4')->
    checkElement('.pagenation ul li a[href="/index.php/en/idProject/3/idIssues?page=5"]', '5')->
  end()->

  get('/index.php/en/idProject/3/idIssues?page=2')->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'index')->
    isParameter('page', '2')->
  end()->

  with('response')->begin()->
    isStatusCode('200')->

    checkElement('.menu div:contains("Id")')->
    checkElement('.menu div:contains("Name")')->
    checkElement('.menu div:contains("Tracker")')->
    checkElement('.menu div:contains("Status")')->
    checkElement('.menu div:contains("Priority")')->
    checkElement('.menu div:contains("Assigned To")')->

    checkElement('.pagenation ul li a[href="/index.php/en/idProject/3/idIssues?page=1"]', 3)->
    checkElement('.pagenation ul li a.current_page', '2')->
    checkElement('.pagenation ul li a[href="/index.php/en/idProject/3/idIssues?page=3"]', '3')->
    checkElement('.pagenation ul li a[href="/index.php/en/idProject/3/idIssues?page=4"]', '4')->
    checkElement('.pagenation ul li a[href="/index.php/en/idProject/3/idIssues?page=5"]', '5')->
  end()->

  get('/en/idProject/4/idIssues')->
  with('response')->begin()->
    isStatusCode('200')->
    checkElement('li:contains("No results")')->
  end();
