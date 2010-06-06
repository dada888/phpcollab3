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
  click('Edit')->

  with('request')->begin()->
    isParameter('module', 'idMessage')->
    isParameter('action', 'edit')->
  end()->

  click('Save', array('message' => array('title' => 'Primo primo', 'body' => 'body primo primo' )))->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idMessage')->
    isParameter('action', 'edit')->
  end()->

  with('response')->begin()->
    checkElement('textarea::contains("Primo primo")')->
    checkElement('textarea::contains("body primo primo")')->
    checkElement('div::contains("Object updated successfully")')->
  end()->

  click('Save', array('message' => array('title' => '', 'body' => '' )))->

  with('request')->begin()->
    isParameter('module', 'idMessage')->
    isParameter('action', 'update')->
  end()->

  with('response')->begin()->
    checkElement('td::contains("Title cannot be empty")')->
    checkElement('td::contains("Body cannot be empty")')->
  end()

  ;
