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

  click('Add')->

  with('request')->begin()->
    isParameter('module', 'idTracker')->
    isParameter('action', 'new')->
  end()->

  click('Save', array(
                      'tracker' => array(
                                            'name' => 'bug'
                      )
    ))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idTracker')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->

    checkElement('table.table td a[href="/index.php/en/idTracker/edit/1"]')->
    checkElement('table.table td:contains("bug")')->
end();
