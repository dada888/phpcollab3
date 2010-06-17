<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();
$browser->loadEventFixtures();


$browser->
  get('/')->

  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idDashboard')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('#content .title', '/Recent Activity/', array('position' => 0))->
    checkElement('#content .title', '/Tickets/', array('position' => 1))->
    checkElement('ul.action li.icon-green', 3)->
  end()->

  click('Dashboard')->

  click('Logout')->
  followRedirect()->
  
  click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idDashboard')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('#content .title', '/Recent Activity/', array('position' => 0))->
    checkElement('#content .title', '/Tickets/', array('position' => 1))->

    checkElement('ul.action li.icon-red', 2)->
    checkElement('ul.action li.icon-green', 11)->

    checkElement('#sidebar')->
    checkElement('#sidebar h3 a', 5)->
    checkElement('#sidebar .box', 5)->
    checkElement('#sidebar .box .percent', '43.48%', array('position' => 0))->

    checkElement('#sidebar .box .progress div[class="progress-green"][style*="43.48%"]', true)->
    checkElement('#sidebar .box .progress div[class="progress-grey"][style*="4.35%"]', true)->

    checkElement('#sidebar:contains("Milestones")')->
    checkElement('#sidebar h3', 'first iteration', array('position' => 2))->
    checkElement('#sidebar h3', 'third iteration', array('position' => 3))->
    checkElement('#sidebar h3', 'second iteration', array('position' => 4))->
    checkElement('#sidebar .box .milestone-red', '5 days', array('position' => 1))->
    checkElement('#sidebar .box .milestone-red', '2 days', array('position' => 3))->
    checkElement('#sidebar .box .milestone-green', '15 days', array('position' => 1))->
  end()

;