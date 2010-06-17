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
    checkElement('table.table tr td input[name="log_time[log_time]"]')->
    checkElement('table.table tr td input[type="submit"][value="Add"]')->
  end()->

  click('Add', array('log_time' => array('log_time' => '0.5')))->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'show')->
    isParameter('issue_id', '1')->
  end()->

  with('response')->begin()->
    isStatusCode('200')->
    checkElement('p:contains("Log time added")')->
  end()->

  click('Add', array('log_time' => array('log_time' => '1.1')))->
  followRedirect()->

  with('response')->begin()->
    isStatusCode('200')->
    checkElement('p:contains("Log time added")')->
  end()->

  click('My log time report')->

  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'reportForActualUser')->
    isParameter('issue_id', '1')->
  end()->

   with('response')->begin()->
   //debug()->
    isStatusCode('200')->
    checkElement('table.table tr th:contains("Date")')->
    checkElement('table.table tr th:contains("Logtime")')->

    checkElement('table.table tr.odd td', '/'.date('Y-m-d', strtotime('-2 days')).'/', array('position' => 1))->
    checkElement('table.table tr.odd td', '/12/', array('position' => 2))->
    checkElement('table.table tr.even td', '/'.date('Y-m-d', strtotime('today')).'/', array('position' => 1))->
    checkElement('table.table tr.even td', '/0.5/', array('position' => 2))->
    checkElement('table.table tr.odd td', '/'.date('Y-m-d', strtotime('today')).'/', array('position' => 5))->
    checkElement('table.table tr.odd td', '/1.1/', array('position' => 6))->

    checkElement('#total_log_time', '/13.6/')->

  end()->


  click('Dashboard')->
  click('Logout')->
  followRedirect()->


  get('/')->
  click('Login', array('signin' => array('username' => 'pmanager', 'password' => 'pmanager')))->
  followRedirect()->

  click('Projects')->
  click('Il mio primo progetto')->
  click('Issues')->

  click('#69')->

  click('My log time report')->

  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'reportForActualUser')->
    isParameter('issue_id', '69')->
  end()->

   with('response')->begin()->
    isStatusCode('200')->
    checkElement('table.table tr th:contains("Date")')->
    checkElement('table.table tr th:contains("Logtime")')->

    checkElement('table.table tr.odd td', '/'.date('Y-m', strtotime('today')).'/', array('position' => 1))->
    checkElement('table.table tr.odd td', '/1.2/', array('position' => 2))->

    checkElement('#total_log_time', '/1.2/')->
  end()->

  click('Go back to issue')->

  click('All users log time report')->

  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'reportForAllUsers')->
    isParameter('issue_id', '69')->
  end()->

   with('response')->begin()->
    isStatusCode('200')->
    checkElement('table.table tr th:contains("User")')->
    checkElement('table.table tr th:contains("Date")')->
    checkElement('table.table tr th:contains("Logtime")')->

    checkElement('table.table tr.odd td', '/paul/', array('position' => 1))->
    checkElement('table.table tr.odd td', '/'.date('Y-m', strtotime('today')).'/', array('position' => 2))->
    checkElement('table.table tr.odd td', '/1.2/', array('position' => 3))->
    checkElement('table.table tr.even td', '/prog/', array('position' => 1))->
    checkElement('table.table tr.even td', '/'.date('Y-m-d', strtotime('-1 days')).'/', array('position' => 2))->
    checkElement('table.table tr.even td', '/1.3/', array('position' => 3))->

    checkElement('#total_log_time', '/2.5/')->

  end()

;
