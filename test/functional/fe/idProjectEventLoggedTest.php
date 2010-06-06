<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Projects')->

  click('Il mio quarto progetto')->

  click('Milestones')->

  with('response')->begin()->
    checkElement('a[href*="en/idProject/4/idMilestone/new"]', 'Create a new milestone')->
  end()->
  click('Create a new milestone')->
  
  with('request')->begin()->
    isParameter('module', 'idMilestone')->
    isParameter('action', 'new')->
  end()->

  with('response')->begin()->
    checkElement('h2', '/Project: Il mio quarto progetto/')->
  end();

  $some_day = explode('-',date('Y-n-d', strtotime('-67 days')));
  $browser->click('Save', array('milestone' => array(
    'title'           => 'first iteration',
    'description'     => 'first iteration of this project',
    'starting_date'   => array('day' => $some_day[2], 'month' => $some_day[1], 'year' => $some_day[0]),
    'ending_date'     => array('day' => date('d', strtotime('+1 month')), 'month' => date('m', strtotime('+1 month')), 'year' => date('Y', strtotime('+1 month')))
  )), array('methos'=>'post'))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'show')->
    isParameter('id', '4')->
  end()->

  click('first iteration')->

  click('Edit')->

  with('response')->begin()->
    checkElement('select[id="milestone_starting_date_month"] option[value="'.$some_day[1].'"][selected="selected"]')->
    checkElement('select[id="milestone_starting_date_day"] option[value="'.$some_day[2].'"][selected="selected"]')->
    checkElement('select[id="milestone_starting_date_year"] option[value="'.$some_day[0].'"][selected="selected"]')->
  end()->

  get('/')->
  with('response')->begin()->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/Amministro A./')->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row', '/Created Milestone/')->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row a[href*="idMilestone/show"]', '/first iteration/')->
    checkElement('.contentWrapper .dashboard .recent .dashboard-row a[href*="show/4"]', '/Il mio quarto progetto/')->
  end()
  ;