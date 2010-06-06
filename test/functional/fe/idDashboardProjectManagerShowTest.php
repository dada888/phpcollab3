<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();
$browser->loadEventFixtures();

$browser->
  get('/')->

  click('Login', array('signin' => array('username' => 'pmanager', 'password' => 'pmanager')))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idDashboard')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('.contentWrapper .dashboard h3:contains("Project Status")')->
    checkElement('.contentWrapper .dashboard .percent:contains("43.48%")')->
    checkElement('.contentWrapper .dashboard a:contains("Il mio primo progetto")')->
    checkElement('.contentWrapper .dashboard .percent:contains("0%")')->
    checkElement('.contentWrapper .dashboard a:contains("Gant chart project")')->
    checkElement('.contentWrapper .dashboard .report:contains("On Time")', 2)->
    checkElement('.contentWrapper .dashboard .report:contains("On Budget")', 2)->

    
    checkElement('.contentWrapper .dashboard h3:contains("Recent Activity")')->
    //checkElement('.contentWrapper .dashboard .recent strong:contains("Frank Tony")', 10)->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/Frank Tony/', array('position' => 0))->
    checkElement('.contentWrapper .dashboard .recent a:contains("Il mio primo progetto")')->

    checkElement('#sidebar-right h3:contains("Milestones")')->
    checkElement('#sidebar-right .milestone-red:contains("Late")')->
    checkElement('#sidebar-right .red:contains("days late")')->
    checkElement('#sidebar-right .milestone-green:contains("Upcoming")')->
    checkElement('#sidebar-right .green:contains("Starts in")')->
  end()
;