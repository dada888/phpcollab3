<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->

  click('Il mio terzo progetto')->

  click('Issues')->

  click('#1')->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'show')->
    isParameter('issue_id', '1')->
  end()->

  with('response')->begin()->
    isStatusCode('200')->

    checkElement('.key:contains("Tracker:")')->
    checkElement('.key:contains("Status:")')->
    checkElement('.key:contains("Priority:")')->
    checkElement('.key:contains("Milestone:")')->
    checkElement('.key:contains("Estimated time:")')->
    checkElement('.key:contains("Starging date:")')->
    checkElement('.key:contains("Ending date:")')->
    checkElement('.key:contains("Assigned to:")')->
    checkElement('.key:contains("Log time:")')->
    checkElement('a[href*="en/idProject/3/idIssue/edit/1"]', 'Edit')->
    checkElement('a[href*="en/idProject/3/idIssue/delete/1"]', 'Delete')->

    checkElement('form input[name="fd_comment[title]"]')->
    checkElement('form textarea[name="fd_comment[body]"]')->
    checkElement('form input[value="Leave a comment"]')->

    checkElement('h4:contains("pippo2")')->
    checkElement('p:contains("pippo2")')->

    checkElement('a[href*="en/idProject/3/idIssue/show/2"]', '#2')->
    checkElement('a[href*="en/idProject/3/idIssue/show/3"]', '#3')->
    checkElement('a[href*="en/idProject/3/idIssue/show/4"]', '#4')->
    checkElement('a[href*="en/idProject/3/idIssue/show/6"]', false)->
  end()->

  click('Issues')->

  click('#5')->

   with('response')->begin()->
    isStatusCode('200')->

    checkElement('a[href="/index.php/en/idProject/3/idIssue/show/1"]', '#1')->
    
  end()->

  click('Issues')->

  click('#2')->

  with('response')->begin()->
    isStatusCode('200')->

    checkElement('ul li:contains("Prog P.")')->
    checkElement('ul li:contains("Mario W.")')->

  end()

;
