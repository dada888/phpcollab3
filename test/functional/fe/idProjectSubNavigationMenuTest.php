<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->
  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Projects')->

  with('response')->begin()->
    isStatusCode(200)->
  end()->

  click('Il mio terzo progetto')->

  with('response')->begin()->
    checkElement('.project-navigation ul li', 'Il mio terzo progetto', array('position' => 0))->
    checkElement('.project-navigation ul li a[href*="en/idProject/3/idIssues"]', 'Issues')->
    checkElement('.project-navigation ul li a[href*="en/idProject/3/idMilestone"]', 'Milestones')->
    checkElement('.project-navigation ul li a[href*="en/idProject/3/idMessages"]', 'Discussions')->
    checkElement('.project-navigation ul li a[href*="en/idLogtime/reportalluserforproject/3"]', 'Time report')->
    checkElement('.project-navigation ul li a[href*="en/idProject/3/staff_list"]', 'Staff')->
    checkElement('.project-navigation ul li a', 'Settings', array('position' => 5))->
  end();
