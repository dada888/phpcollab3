<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->
  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  
  followRedirect()->
  
  click('Projects')->
  
  click('Il mio primo progetto')->

  with('response')->begin()->
    checkElement('.project-navigation ul li a[href*="en/idProject/1/staff_list"]', 'Staff')->
  end()->


  click('Staff')->

  with('response')->begin()->
    checkElement('.title', '/Staff/')->
    checkElement('.title a', '/Edit/')->
  end()->

  click('Save', array('project' => array('users_list' => array('3' => 'Mario (user) Wage <mario@example.com>'))))->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'updateStaffList')->
    isParameter('id', '1')->
  end()->

  with('response')->begin()->
    checkElement('body:contains("Mario W.")')->
    checkElement('body:contains("mario@example.com")')->
    checkElement('body:contains("developer")')->
  end();