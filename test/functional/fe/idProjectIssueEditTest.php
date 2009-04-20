<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('a[href="/index.php/en/idProject/show/1"]', false)->
    checkElement('a[href="/index.php/en/idProject/show/2"]', false)->
    checkElement('td:contains("3")')->
  end()->

  click('3')->

  click('Issues')->

  click('Edit', array(), array('position'=>1))->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'edit')->
    isParameter('issue_id', '1')->
    isParameter('id', '3')->
  end();


$browser->click('Save', array('issue' => array(
    'title'           => 'new ticket up',
    'description'     => 'new issue for this project up',
    'status_id'       => 1,
    'priority_id'     => 1,
    'starting_date'   => array('day' => date('d', time()), 'month' => date('m', time()), 'year' => date('Y', time())),
    'ending_date'     => array('day' => date('d', strtotime('+1 month')), 'month' => date('m', strtotime('+1 month')), 'year' => date('Y', strtotime('+1 month'))),
    'users_list'       => array('3')
  )), array('methos'=>'post'))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'index')->
  end()->

  responseContains('new ticket up')->
  responseContains('new issue for this project up')

;
