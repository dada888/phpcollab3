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

  with('response')->begin()->
    checkElement('.statusTitle', 4)->
    checkElement('.statusTitle a:contains("Il mio terzo progetto")')->
    checkElement('.statusTitle a:contains("Il mio secondo progetto")')->
    checkElement('.report div:contains("On Time")')->
    checkElement('.report div:contains("On Budget")', false)->
    checkElement('.report div:contains("Tickets Remain")')->
    checkElement('.report div:contains("Tickets Closed")')->
    checkElement('.report div:contains("Discussions")')->
    checkElement('.report div:contains("Commits")')->
  end()->

  click('Logout')->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->

  with('response')->begin()->
    checkElement('a[href="/index.php/en/idProject"]', 'Projects')->
  end();
