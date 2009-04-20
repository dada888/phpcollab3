<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();


$browser->
  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->

  click('Projects')->
  
  click('1')->

  with('response')->begin()->
    checkElement('div.secondary-navigation ul li a[href="/index.php/en/idProject/edit/1"]', 'Add user(s)')->
  end()->


  click('Add user(s)')->

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

  responseContains('User(s) of this project')->
  responseContains('mario@example.com')->
  responseContains('user');