<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();

$browser->

get('/en/idProject/edit/1')->

click('Login', array('signin' => array('username' => 'nouser', 'password' => 'nouser')))->

  with('request')->begin()->
    isParameter('module', 'sfGuardAuth')->
    isParameter('action', 'signin')->
  end()->

click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
  followRedirect()->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

click('Logout')->

followRedirect()->

click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->

  click('Projects')->

  with('response')->begin()->
  //debug()->
  isStatusCode(200)->

  checkElement('div#block-tables div.content div.inner table.table tr th:contains("Name")')->
  checkElement('div#block-tables div.content div.inner table.table tr th:contains("Description")')->
  checkElement('div#block-tables div.content div.inner table.table tr th:contains("Public")')->
  end();

$browser->
  info('Delete a project')->
  get('/en/idProject/delete/1')->
  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'delete')->
  end()->

followRedirect()->

  with('response')->begin()->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio primo progetto")', false)->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio secondo progetto")')->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio terzo progetto")')->
  end()
;
