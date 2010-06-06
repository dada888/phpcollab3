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

  click('Issues')->

  click('Create new issue');


$browser->click('Save', array('issue' => array(
    'title'           => 'new ticket',
    'description'     => 'new issue for this project',
    'status_id'       => 1,
    'priority_id'     => 1,
    'starting_date'   => array('day' => date('d', time()), 'month' => date('m', time()), 'year' => date('Y', time())),
    'ending_date'     => array('day' => date('d', strtotime('+1 month')), 'month' => date('m', strtotime('+1 month')), 'year' => date('Y', strtotime('+1 month'))),
    'users_list'       => array('1')
  )), array('methos'=>'post'))->

  responseContains('Invalid.');


  $browser->click('Save', array('issue' => array(
    'title'           => ''
  )), array('methos'=>'post'))->

  responseContains('Title is mandatory');

  $browser->click('Save', array('issue' => array(
    'title'           => 'new ticket',
    'description'     => 'new issue for this project',
    'status_id'       => 1,
    'priority_id'     => 1,
    'starting_date'   => array('day' => date('d', time()), 'month' => date('m', time()), 'year' => date('Y', time())),
    'ending_date'     => array('day' => date('d', strtotime('+1 month')), 'month' => date('m', strtotime('+1 month')), 'year' => date('Y', strtotime('+1 month'))),
    'issues_list'     => array('11111111111')
  )), array('methos'=>'post'))->

  responseContains('Invalid.');

  $browser->click('Save', array('issue' => array(
    'title'           => 'new ticket',
    'description'     => 'new issue for this project',
    'status_id'       => 1,
    'priority_id'     => 1,
    'starting_date'   => array('day' => date('d', time()), 'month' => date('m', time()), 'year' => date('Y', time())),
    'ending_date'     => array('day' => date('d', strtotime('+1 month')), 'month' => date('m', strtotime('+1 month')), 'year' => date('Y', strtotime('+1 month'))),
    'issues_list'     => array('-20')
  )), array('methos'=>'post'))->

  responseContains('Invalid.');
