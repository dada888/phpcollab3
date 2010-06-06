<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->

  click('Projects')->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('a[href="/index.php/en/idProject/show/1"]', false)->
    checkElement('a[href="/index.php/en/idProject/show/2"]')->
  end()->

  click('Il mio terzo progetto')->

  click('Issues')->

  click('Create new issue')->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'new')->
  end();


$browser->click('Save', array('issue' => array(
    'title'           => 'new ticket',
    'description'     => 'new issue for this project',
    'status_id'       => 1,
    'priority_id'     => 1,
    'starting_date'   => array('day' => date('d', time()), 'month' => date('m', time()), 'year' => date('Y', time())),
    'ending_date'     => array('day' => date('d', strtotime('+1 month')), 'month' => date('m', strtotime('+1 month')), 'year' => date('Y', strtotime('+1 month'))),
    'users_list'       => array('3'),
    'milestone_id'       => 3
  )), array('methos'=>'post'))->


  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'index')->
  end()->

  click('Last')->

  responseContains('new ticket')->
  responseContains('new issue for this project')

;
