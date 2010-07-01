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

  with('request')->begin()->
    isParameter('module', 'idMilestone')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('ul li a[href="/index.php/en/idProject/1/idMilestone/show/1"]', '/first iteration/', array('position' => 1))->
    checkElement('ul li  a[href="/index.php/en/idProject/1/idMilestone/show/2"]', '/second iteration/', array('position' => 1))->
  end();
