<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->
  get('/')->

  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idDashboard')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('.contentWrapper .dashboard h3:contains("Tickets")')->
    checkElement('.contentWrapper .dashboard .milestone-green:contains("Due")')->
    checkElement('.contentWrapper .dashboard .milestone-green:contains("Upcoming/Today")')->
    checkElement('.contentWrapper .dashboard .milestone-thin-green .dashboard-row a[href*="idProject/3/idIssue/show/1"]', '/#1/')->
    checkElement('.contentWrapper .dashboard .milestone-thin-green .dashboard-row p:contains("new issue")')->
    checkElement('.contentWrapper .dashboard .milestone-thin-green .dashboard-row p a[href*="idProject/show/3"]', '/Il mio terzo progetto/')->
    checkElement('.contentWrapper .dashboard .milestone-thin-green .dashboard-row .list-date', '/'.strftime('%B %d', strtotime('+10 days GMT')).'/', array('position'=>2))->
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
    checkElement('.contentWrapper .dashboard h3:contains("Tickets")')->
    checkElement('.contentWrapper .dashboard:contains("Due")')->
    checkElement('.contentWrapper .dashboard:contains("Upcoming/Today")')->
    checkElement('.contentWrapper .dashboard .milestone-thin-green .dashboard-row a[href*="idProject/3/idIssue/show/2"]', '/#2/', array('position' => 0))->
    checkElement('.contentWrapper .dashboard .milestone-thin-green .dashboard-row p:contains("new issue 2")')->
    checkElement('.contentWrapper .dashboard .milestone-thin-green .dashboard-row a[href*="idProject/show/3"]', '/Il mio terzo progetto/', array('position' => 1))->

    checkElement('#sidebar-right')->
    checkElement('#sidebar-right h3:contains("Open Projects")')->
    checkElement('#sidebar-right h3:contains("Milestones")')->
    checkElement('#sidebar-right .menuStatus .statusTitle a:contains("Il mio primo progetto")')->
    checkElement('#sidebar-right .grey-box', '/43.48%/')->
    checkElement('#sidebar-right .grey-box .percent', '/43.48%/')->
    checkElement('#sidebar-right .grey-box .progress')->
    checkElement('#sidebar-right .grey-box .report', 6)->
    checkElement('#sidebar-right .milestone-thin-red strong:contains("days late")')->
    checkElement('#sidebar-right .milestone-thin-green strong:contains("Starts in")')->
  end()

;