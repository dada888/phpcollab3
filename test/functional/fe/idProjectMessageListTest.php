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
    checkElement('table.table tr th:contains("Title")')->
    checkElement('table.table tr th:contains("Creation date")')->
    checkElement('table.table tr th:contains("Created by")')->
    
    checkElement('table.table tr td:contains("Primo messaggio")')->
    checkElement('table.table tr td a[href~="idProject/2/idMessage/show/1"]', 'Primo messaggio')->
    checkElement('table.table tr td:contains("Secondo messaggio")')->
    checkElement('table.table tr td a[href~="idProject/2/idMessage/show/2"]', 'Secondo messaggio')->
    checkElement('table.table tr td:contains("prog (puser) prog")', 2)->

    checkElement('table.table tr td:contains("Edit")', 2)->
    checkElement('table.table tr td:contains("Delete")', 2)->
  end()

  ;
