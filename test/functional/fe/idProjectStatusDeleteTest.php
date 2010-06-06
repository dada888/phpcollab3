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

  with('response')->begin()->
    checkElement('tr', 5)->
    checkElement('td:contains("new")', 2)->
    checkElement('td:contains("invalid")', 2)->
  end()->

  click('Delete')->

 followRedirect()->

  with('response')->begin()->
    checkElement('tr', 4)->
    checkElement('td:contains("new")', false)->
    checkElement('td:contains("invalid")', 2)->
  end()->

  click('Create new status')->

  click('Save', array(
                      'status' => array(
                                            'name' => 'pipponia',
                                            'status_type' => 'closed'
                                       )
                     )
       )->

  followRedirect()->

  click('Create new status')->

  click('Save', array(
                      'status' => array(
                                            'name' => 'chichirichi',
                                            'status_type' => 'closed'
                                       )
                     )
       )->

  followRedirect()->

  click('Up', array(), array('position' => 2))->
  followRedirect()->

  click('Delete', array(), array('position' => 2))->

  followRedirect()->

  with('response')->begin()->
    checkElement('#block-tables table.table td:contains("new")', false)->
    checkElement('#block-tables table.table td:contains("invalid")', false)->
    checkElement('#block-tables table.table td:contains("chichirichi")')->
    checkElement('#block-tables table.table td:contains("pipponia")')->
  end()

;
