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

  click('View all project milestones')->

  click('Edit')->

  with('response')->begin()->
    checkElement('input[value="third iteration"]')->
    checkElement('textarea:contains("third iteration for project 3")')->
  end()->

  click('Save', array('milestone' => array(
    'title'           => 'third iteration modified',
    'description'     => 'third iteration of this project modified',
    'estimated_time'   => '15',
    'starting_date'   => array('day' => date('d', strtotime('today')), 'month' => date('m', strtotime('today')), 'year' => date('Y', strtotime('today'))),
    'ending_date'     => array('day' => date('d', strtotime('+1 month')), 'month' => date('m', strtotime('+1 month')), 'year' => date('Y', strtotime('+1 month')))
  )), array('methos'=>'post'))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'show')->
    isParameter('id', '3')->
  end()->

  click('Milestones')->
  click('third iteration modified')->
  click('Edit')->

  with('response')->begin()->
   checkElement('input[name="milestone[estimated_time]"][value="15"]')->
  end()
;
