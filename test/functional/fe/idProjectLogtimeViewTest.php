<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'pmanager', 'password' => 'pmanager')))->
  followRedirect()->

  click('Projects')->
  click('Gant chart project')->
  click('Time report')->

  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'reportAllUsersForProject')->
    isParameter('project_id', '5')->
  end()->

   with('response')->begin()->
    checkElement('li:contains("Paul M.")', 4)->
    checkElement('li:contains("5.0")')->
    checkElement('li:contains("10.0")')->
    checkElement('li:contains("third user story")')->
    checkElement('li:contains("first task")')->
    checkElement('li:contains("'.date("F d Y", strtotime('-2 days')).'")', 2)->
    checkElement('li:contains("'.date("F d Y", strtotime('-3 days')).'")', 2)->
  end()
;