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

  click('Add')->

  click('Save', array('milestone' => array(
    'title'           => ''
  )), array('methos'=>'post'))->

  responseContains('Title is mandatory')->

  click('Save', array('milestone' => array(
    'title'           => 'titolo',
    'project_id'      => -1
  )), array('methos'=>'post'))->

  responseContains('Invalid');