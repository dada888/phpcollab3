<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();
$browser->loadEventFixtures();

$browser->
  get('/')->

  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idDashboard')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('.contentWrapper .dashboard h3:contains("Recent Activity")')->
    checkElement('.contentWrapper .dashboard .recent .menu span:contains("'.date('F d',  strtotime('today GMT')).'")')->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/Frank Tony/')->

    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 19/', array('position' => 0))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 18/', array('position' => 1))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 17/', array('position' => 2))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 16/', array('position' => 3))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 15/', array('position' => 4))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 14/', array('position' => 5))->

    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 29/', array('position' => 10))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 28/', array('position' => 11))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 27/', array('position' => 12))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 26/', array('position' => 13))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 25/', array('position' => 14))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 24/', array('position' => 15))->

    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 39/', array('position' => 20))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 38/', array('position' => 21))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 37/', array('position' => 22))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 36/', array('position' => 23))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 35/', array('position' => 24))->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/message 34/', array('position' => 25))->

    checkElement('.contentWrapper .dashboard .recent .dashboard-row:contains("message 4")', false)->

    checkElement('.contentWrapper .dashboard .recent .menu span:contains("'.date('F d', strtotime('-1 days GMT')).'")')->
    checkElement('.contentWrapper .dashboard .recent .menu span:contains("'.date('F d', strtotime('-2 days GMT')).'")')->
    checkElement('.contentWrapper .dashboard .recent .menu .right span:contains("Project")')->
    checkElement('#sidebar-right')->
    checkElement('#sidebar-right h3:contains("Open Projects")')->
    
    checkElement('#sidebar-right .menuStatus .statusTitle a:contains("Il mio primo progetto")')->
    checkElement('#sidebar-right .grey-box .percent:contains("43.48%")')->
    checkElement('#sidebar-right .grey-box .progress div[class="progress-green"][style*="43.48%"]', true, array('position' => 0))->
    checkElement('#sidebar-right .grey-box .progress div[class="progress-grey"][style*="4.35%"]', true)->

    checkElement('#sidebar-right .grey-box .report a[href*="idIssues"]', '/13/', array('position' => 4))->
    checkElement('#sidebar-right .grey-box .report span:contains("Tickets Remain")')->

    checkElement('#sidebar-right .grey-box .report a[href*="idIssues"]', '/10/', array('position' => 5))->
    checkElement('#sidebar-right .grey-box .report span:contains("Tickets Closed")')->

    checkElement('#sidebar-right .grey-box .report a[href*="idMessage"]', '/2/', array('position' => 1))->
    checkElement('#sidebar-right .grey-box .report span:contains("Discussions")')->

  end()
;