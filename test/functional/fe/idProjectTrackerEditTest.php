<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/')->
click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Settings')->
  click('Trackers')->

  click('Edit')->

  with('request')->begin()->
    isParameter('module', 'idTracker')->
    isParameter('action', 'edit')->
  end()->

  with('response')->begin()->
    checkElement('input[id="tracker_name"][value="user story"]')->
  end()->

  click('Save', array(
                      'tracker' => array(
                                            'name' => 'user story the best',
                                       )
                     )
       )->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idTracker')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('table.table td:contains("user story the best")')->
  end()->

  click('Edit')->

  with('request')->begin()->
    isParameter('module', 'idTracker')->
    isParameter('action', 'edit')->
  end()->

  click('Save', array(
                      'tracker' => array(
                                            'name' => '12345678901234567890123456789012345678901234567890
                                                       12345678901234567890123456789012345678901234567890
                                                       12345678901234567890123456789',
                                       )
                     )
       )->

  responseContains('is too long (128 characters max)');

