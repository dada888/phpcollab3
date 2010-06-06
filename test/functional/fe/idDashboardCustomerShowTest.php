<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();
$browser->loadEventFixtures();

$browser->
  get('/')->

  click('Login', array('signin' => array('username' => 'customer', 'password' => 'customer')))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idDashboard')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('.contentWrapper .dashboard h3:contains("Recent Activity")')->
    checkElement('.contentWrapper .dashboard .recent .menu span:contains("'.date('F', strtotime('-2 days GMT')).'")')->
    checkElement('.contentWrapper .dashboard .recent .menu .right span:contains("Project")')->

    checkElement('.contentWrapper .dashboard .recent .dashboard-row:contains("message 22")', false)->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row:contains("message 42")', false)->

    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 19/', array('position' => 0))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 18/', array('position' => 1))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 17/', array('position' => 2))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 16/', array('position' => 3))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 15/', array('position' => 4))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 14/', array('position' => 5))->

    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 39/', array('position' => 10))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 38/', array('position' => 11))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 37/', array('position' => 12))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 36/', array('position' => 13))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 35/', array('position' => 14))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 34/', array('position' => 15))->


    checkElement('#sidebar-right')->
    checkElement('#sidebar-right h3:contains("Open Projects")')->
    checkElement('#sidebar-right .menuStatus .statusTitle a:contains("Il mio primo progetto")')->
    checkElement('#sidebar-right .menuStatus .statusTitle a:contains("Il mio terzo progetto")')->
    checkElement('#sidebar-right h3:contains("Milestones")')->
    
    checkElement('#sidebar-right .milestone-red:contains("Late")')->
    checkElement('#sidebar-right .red:contains("days late")')->
    
    checkElement('#sidebar-right .milestone-green:contains("Upcoming")')->
    checkElement('#sidebar-right .green:contains("Starts in")')->
  end()
;