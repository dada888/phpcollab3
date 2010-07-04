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

  click('Add', array('log_time' => array('log_time' => '124.1')))->
  followRedirect()->

  with('response')->begin()->
    isStatusCode('200')->
    checkElement('.notice:contains("Log time added")')->
  end()->

  click('Add', array('log_time' => array('log_time' => '-312')))->
  followRedirect()->
  
  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'show')->
    isParameter('issue_id', '1')->
  end()->

  with('response')->begin()->
    isStatusCode('200')->
    checkElement('li:contains("You cannot set a negative log time")')->
  end()
;
