<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/')->
click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Settings')->
  click('Priorities')->

  click('Add')->

  with('request')->begin()->
    isParameter('module', 'idPriority')->
    isParameter('action', 'new')->
  end()->

  click('Save', array(
                      'priority' => array(
                                            'name' => 'high'
                      )
    ))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idPriority')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->

    checkElement('table.table td a[href="/index.php/en/idPriority/edit/2"]')->
    checkElement('table.table td:contains("high")')->
end();
