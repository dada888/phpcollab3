<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/')->
click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  //click('Statuses')->
  get('/en/idStatus')->

  click('Create new status')->
  

  with('request')->begin()->
    isParameter('module', 'idStatus')->
    isParameter('action', 'new')->
  end()->

  with('response')->begin()->
    checkElement('select#status_status_type option[value="new"]', 'new')->
    checkElement('select#status_status_type option[value="invalid"]', 'invalid')->
    checkElement('select#status_status_type option[value="closed"]', 'closed')->
    checkElement('select#status_status_type option', 4)->
  end()->

  click('Save', array(
                      'status' => array(
                                            'name' => 'rejected',
                                            'status_type' => 'invalid'
                                       )
                     )
       )->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idStatus')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->

    checkElement('#block-tables table.table th:contains("Status type")')->
    checkElement('#block-tables table.table td:contains("rejected")')->

    checkElement('#block-tables table.table td a[href="/index.php/en/idStatus/edit/2"]')->
    checkElement('#block-tables table.table td:contains("rejected")')->
end();