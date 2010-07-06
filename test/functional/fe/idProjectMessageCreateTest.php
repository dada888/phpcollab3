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
  click('Add')->

  with('request')->begin()->
    isParameter('module', 'idMessage')->
    isParameter('action', 'new')->
  end()->

  click('Save', array('message' => array('title' => 'Terzo', 'body' => 'body terzo' )))->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idMessage')->
    isParameter('action', 'edit')->
  end()->

  with('response')->begin()->
    checkElement('input[value="Terzo"]')->
    checkElement('textarea:contains("body terzo")')->
    checkElement('.notice','/Object created successfully/')->
  end()
;
