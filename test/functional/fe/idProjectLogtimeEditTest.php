<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Time')->

  click('Edit')->

  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'edit')->
  end()->

  click('Save', array('log_time' => array(
        'log_time' => '14'
      )), array('methos'=>'post'))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'edit')->
  end()->

  click('Cancel')->

  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('table.table tr th:contains("Logtime id")')->
    checkElement('table.table tr th:contains("Issue")')->
    checkElement('table.table tr th:contains("User")')->
    checkElement('table.table tr th:contains("Date")')->
    checkElement('table.table tr th:contains("Logtime")')->
    checkElement('table.table tr th:contains("Actions")')->

    checkElement('table.table tr td a[href="/index.php/en/idLogtime/edit/1"]', '1')->
    checkElement('table.table tr td a[href="/index.php/en/idProject/3/idIssue/show/1"]', '#1 new issue')->
    checkElement('table.table tr td:contains("prog (puser) prog")')->
    checkElement('table.table tr td:contains("14")')->
    checkElement('table.table tr td:contains("Edit")')->
    checkElement('table.table tr td:contains("Delete")')->
  end()
;