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
    'title'           => 'new ticket new',
    'description'     => 'new issue for this project new',
    'status_id'       => 1,
    'priority_id'     => 1,
    'starting_date'   => array('day' => date('d', time()), 'month' => date('m', time()), 'year' => date('Y', time())),
    'ending_date'     => array('day' => date('d', strtotime('+1 month')), 'month' => date('m', strtotime('+1 month')), 'year' => date('Y', strtotime('+1 month'))),
    'users_list'       => array('3'),
    'milestone_id'       => 1
  )), array('methos'=>'post'))->

  responseContains('Invalid.');
