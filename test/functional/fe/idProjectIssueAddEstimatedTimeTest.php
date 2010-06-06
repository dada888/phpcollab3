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
    checkElement('table.table tr td input[name="issue[estimated_time]"]')->
    checkElement('table.table tr td input[type="submit"][value="Set"]')->
  end()->

  click('Set', array('issue' => array('estimated_time' => '0.5')))->

  //with('response')->begin()->
  //  debug()->
  //end()->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'show')->
    isParameter('issue_id', '1')->
  end()->

  with('response')->begin()->
    isStatusCode('200')->
    checkElement('table.table tr td:contains("0.5")')->
  end()->

  click('Set', array('issue' => array('estimated_time' => '1.3', 'id' => 1, 'project_id' => 3)))->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'show')->
    isParameter('issue_id', '1')->
  end()->

  with('response')->begin()->
    isStatusCode('200')->
    checkElement('table.table tr td:contains("1.3")')->
  end()->

  click('Set', array('issue' => array('estimated_time' => '13', 'id' => 1, 'project_id' => 3)))->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'show')->
    isParameter('issue_id', '1')->
  end()->

  with('response')->begin()->
    isStatusCode('200')->
    checkElement('table.table tr td:contains("13")')->
  end()->

  click('Set', array('issue' => array('estimated_time' => '-3', 'id' => 1, 'project_id' => 3)))->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'show')->
    isParameter('issue_id', '1')->
  end()->

  responseContains('You cannot set a negative estimated time')

;
