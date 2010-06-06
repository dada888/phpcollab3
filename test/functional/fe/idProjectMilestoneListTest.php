<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Projects')->

  click('Il mio primo progetto')->
  click('Milestones')->
  click('View all project milestones')->

  with('request')->begin()->
    isParameter('module', 'idMilestone')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('table.table tr td a[href="/index.php/en/idProject/1/idMilestone/show/1"]', '/first iteration/')->
    checkElement('table.table tr td:contains("first iteration for project 1")')->
    checkElement('table.table tr td a[href="/index.php/en/idProject/1/idMilestone/show/2"]', '/second iteration/')->
    checkElement('table.table tr td:contains("second iteration for project one")')->
  end()

  ;
