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
    checkElement('#addIcon', 'Quick Add')->
  end()->

  click('Il mio terzo progetto')->

  with('response')->begin()->
//    checkElement('div.secondary-navigation ul li a[href="/index.php/en/idProject/new"]', 'Create new project')->
//    checkElement('div.secondary-navigation ul li a[href="/index.php/en/idProject/edit/3"]', 'Add user(s)')->
//    checkElement('div.secondary-navigation ul li a[href="/index.php/en/idProject/3/idMilestone/new"]', 'Create a new milestone')->
//    checkElement('div.secondary-navigation ul li a[href="/index.php/en/idProject/3/idIssue/new"]', 'Create issue')->
//    checkElement('div.secondary-navigation ul li a[href="/index.php/en/idProject/3/idIssues"]', 'Issues')->
//    checkElement('div.secondary-navigation ul li a[href="/index.php/en/idProject/3/idMilestone"]', 'View all project milestones')->
  end();
