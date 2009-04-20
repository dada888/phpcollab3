<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();

$browser->

get('/')->
click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Priorities')->

  click('Create new priority')->

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

    checkElement('#block-tables table.table td a[href="/index.php/en/idPriority/edit/2"]')->
    checkElement('#block-tables table.table td:contains("high")')->
end();
