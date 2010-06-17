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
    checkElement('td:contains("pmanager")', 2)->
    checkElement('td:contains("5.0 hours")')->
    checkElement('td:contains("10.0 hours")')->
    checkElement('td:contains("third user story")')->
    checkElement('td:contains("first task")')->
    checkElement('td:contains("'.date("Y-m-d", strtotime('-2 days')).'")', 1)->
    checkElement('td:contains("'.date("Y-m-d", strtotime('-3 days')).'")', 1)->
  end()

;