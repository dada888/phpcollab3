<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();

$browser->

get('/')->
click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Statuses')->

  click('Create new status')->

  with('request')->begin()->
    isParameter('module', 'idStatus')->
    isParameter('action', 'new')->
  end()->

  click('Save', array(
                      'status' => array(
                                            'name' => 'closed'
                      )
    ))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idStatus')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->

    checkElement('#block-tables table.table td a[href="/index.php/en/idStatus/edit/2"]')->
    checkElement('#block-tables table.table td:contains("closed")')->
end();
