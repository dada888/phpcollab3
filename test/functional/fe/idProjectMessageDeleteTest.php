<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->

  click('Projects')->
  click('Il mio secondo progetto')->
  click('Discussions')->

  with('response')->begin()->
    checkElement('table.table tr', 4)->
  end()->

  click('Delete')->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idMessage')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('table.table tr', 3)->
  end()
;