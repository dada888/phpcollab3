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
    checkElement('h3', '/Staff/')->
    checkElement('a[href*="idProject/edit"]', '/Add Members/')->
    checkElement('.recent .menu', 1)->
    checkElement('.recent .dashboard-row', 3)->
  end()->


  click('Add Members')->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'edit')->
    isParameter('id', '1')->
  end()->

click('Update the project', array('project' => array('users_list' => array('3' => 'Mario (user) Wage <mario@example.com>'))))->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'update')->
    isParameter('id', '1')->
  end()->

  responseContains('Project users')->
  responseContains('mario@example.com')->
  responseContains('user');