<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Time')->

  click('Add')->

  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'new')->
  end()->

  click('Save', array('log_time' => array(
        'log_time' => '14',
        'issue_id' => '2',
        'profile_id' => '3'
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
    checkElement('li:contains("Issue")')->
    checkElement('li:contains("User")')->
    checkElement('li:contains("Log time")')->
    
    checkElement('li a[href~="en/idLogtime/edit/16"]', 'Edit')->
    checkElement('li a[href~="en/idProject/3/idIssue/show/2"]', '#2 new issue 2')->
    checkElement('li:contains("Prog P.")')->
    checkElement('li:contains("14")')->
    checkElement('li:contains("Edit")')->
    checkElement('li:contains("Delete")')->
  end()
;