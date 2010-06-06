<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->

  click('Projects')->

  click('Il mio terzo progetto')->
  click('Milestones')->

  click('third iteration')->

  with('response')->begin()->
    checkElement('div.secondary-navigation li a[href="/index.php/en/idProject/3/idMilestone/new"]', 'Create a new milestone')->
    checkElement('div.secondary-navigation li a[href="/index.php/en/idProject/show/3"]', 'Go back to the project dashboard')->
    checkElement('div.secondary-navigation li a[href="/index.php/en/idProject/3/idMilestone"]', 'View all project milestones')->


    checkElement('table.table tr td:contains("third iteration")')->
    checkElement('table.table tr td:contains("third iteration for project 3")')->

    checkElement('a[href="/index.php/en/idProject/3/idMilestone/edit/3"]', 'Edit')->
    checkElement('a[href="/index.php/en/idProject/3/idMilestone/detele/3"]', 'Delete')->

    checkElement('div#milestone-issues-table tr td:contains("new issue 51")')->
    checkElement('div#milestone-issues-table tr td:contains("new issue 52")')->
    checkElement('div#milestone-issues-table tr td:contains("new issue 53")')->
    checkElement('div#milestone-issues-table tr td:contains("new issue 54")')->
    checkElement('div#milestone-issues-table tr td:contains("new issue 55")')->
    checkElement('div#milestone-issues-table tr td:contains("new issue 56")')->
    checkElement('div#milestone-issues-table tr td:contains("new issue 57")')->
    checkElement('div#milestone-issues-table tr td:contains("new issue 58")')->
    checkElement('div#milestone-issues-table tr td:contains("new issue 59")')->
    checkElement('div#milestone-issues-table tr td:contains("new issue 60")')->
    checkElement('div#milestone-issues-table tr td:contains("new issue 61")', false)->

    checkElement('div#milestone-issues-table tr td:contains("third iteration")', 10)->

    checkElement('tr td span', '1')->
    checkElement('tr td a[href="/index.php/en/idProject/3/idMilestone/show/3?page=2"]', '2')->

    checkElement('td:contains("Estimated time : 0.0 hours")')->

  end()->
  
  click('Dashboard')->
  click('Logout')->

  get('/')->

  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Projects')->
  click('Il mio primo progetto')->
  click('Milestones')->
  click('first iteration')->

  with('response')->begin()->
    checkElement('td[class="red"]', '/issues estimated time 101.0 hours/')->
  end()
;