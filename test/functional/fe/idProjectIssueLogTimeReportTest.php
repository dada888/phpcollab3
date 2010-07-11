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
    checkElement('input[name="log_time[log_time]"]')->
    checkElement('input[type="submit"][value="Add"]')->
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
    checkElement('.notice:contains("Log time added")')->
  end()->

  click('Add', array('log_time' => array('log_time' => '1.1')))->
  followRedirect()->

  with('response')->begin()->
    isStatusCode('200')->
    checkElement('.notice:contains("Log time added")')->
  end()->

  click('My log time report')->

  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'reportForActualUser')->
    isParameter('issue_id', '1')->
  end()->

   with('response')->begin()->
    isStatusCode('200')->
    checkElement('ul li.icon-time ul li:contains("'.date('F d Y', strtotime('today')).'")')->
    checkElement('ul li.icon-time ul li:contains("'.date('F d Y', strtotime('-2 days')).'")')->
    checkElement('ul li.icon-time ul li:contains("1.1")')->
    checkElement('ul li.icon-time ul li:contains("0.5")')->
    checkElement('ul li.icon-time ul li:contains("12")')->

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
    checkElement('ul li.icon-time ul li:contains("'.date('F d Y', strtotime('today')).'")')->
    checkElement('ul li.icon-time ul li:contains("1.2")')->
    
    checkElement('#total_log_time', '/1.2/')->
  end()->

  click('#69')->

  click('All users log time report')->

  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'reportForAllUsers')->
    isParameter('issue_id', '69')->
  end()->

   with('response')->begin()->
    isStatusCode('200')->

    checkElement('ul li.icon-time ul li:contains("'.date('F d Y', strtotime('today')).'")')->
    checkElement('ul li.icon-time ul li:contains("Prog P.")')->
    checkElement('ul li.icon-time ul li:contains("1.2")')->
    checkElement('ul li.icon-time ul li:contains("'.date('F d Y', strtotime('-1 day')).'")')->
    checkElement('ul li.icon-time ul li:contains("1.3")')->
    checkElement('ul li.icon-time ul li:contains("Paul M.")')->

    checkElement('#total_log_time', '/2.5/')->

  end()

;
