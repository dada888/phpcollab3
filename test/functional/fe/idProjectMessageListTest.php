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

  with('request')->begin()->
    isParameter('module', 'idMessage')->
    isParameter('action', 'index')->
    isParameter('project_id', '2')->
  end()->

  with('response')->begin()->
    checkElement('.menu div:contains("Title")')->
    checkElement('.menu div:contains("Description")')->
    checkElement('.menu div:contains("Last reply")')->
    
    checkElement('ul li:contains("Primo messaggio")')->
    checkElement('ul li a[href~="idProject/2/idMessage/show/1"]', 'Primo messaggio')->
    checkElement('ul li:contains("Secondo messaggio")')->
    checkElement('ul li a[href~="idProject/2/idMessage/show/2"]', 'Secondo messaggio')->

    checkElement('ul li ul li:contains("Edit")', 2)->
    checkElement('ul li ul li:contains("Delete")', 2)->
  end()

  ;
