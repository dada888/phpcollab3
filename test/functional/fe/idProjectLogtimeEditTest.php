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
        'issue_id' => '1',
        'log_time' => '14'
      )), array('methos'=>'post'))->
  followRedirect()->


  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'edit')->
  end()->

  get('/en/idLogtime')->

  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('li:contains("Issue")')->
    checkElement('li:contains("User")')->
    checkElement('li:contains("Log time")')->

    checkElement('li a[href="/index.php/en/idLogtime/edit/1"]', 'Edit')->
    checkElement('li a[href="/index.php/en/idProject/3/idIssue/show/1"]', '#1 new issue')->
    checkElement('li:contains("Manager P.")')->
    checkElement('li:contains("14")')->
    checkElement('li:contains("Edit")')->
    checkElement('li:contains("Delete")')->
  end()
;