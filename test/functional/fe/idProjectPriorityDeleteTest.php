<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/')->

click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->

  //click('Priorities')->
  get('/en/idPriority')->

  with('response')->begin()->
    checkElement('tr', 3)->
    checkElement('#block-tables table.table td:contains("normal")')->
    checkElement('#block-tables table.table td:contains("high")')->
  end()->

  click('Delete')->

  followRedirect()->

  with('response')->begin()->
    checkElement('tr', 2)->
    checkElement('#block-tables table.table td:contains("normal")', false)->
    checkElement('#block-tables table.table td:contains("high")')->
  end()->

  click('Create new priority')->

  click('Save', array(
                      'priority' => array(
                                            'name' => 'cesena'
                      )
    ))->

  followRedirect()->

  click('Create new priority')->

  click('Save', array(
                      'priority' => array(
                                            'name' => 'micamale'
                      )
    ))->

  followRedirect()->

  click('Up', array(), array('position' => 2))->
  followRedirect()->

  click('Delete', array(), array('position' => 2))->

  followRedirect()->

  with('response')->begin()->
    checkElement('#block-tables table.table td:contains("normal")', false)->
    checkElement('#block-tables table.table td:contains("high")', false)->
    checkElement('#block-tables table.table td:contains("cesena")')->
    checkElement('#block-tables table.table td:contains("micamale")')->
  end()

;
