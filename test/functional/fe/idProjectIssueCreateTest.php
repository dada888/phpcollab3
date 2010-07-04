<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$today = explode('-',date('Y-n-d', strtotime('today')));

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

  click('Add')->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'new')->
  end()->

  with('response')->begin()->
    checkElement('input[id="issue_title"]')->
    checkElement('textarea[id="issue_description"]')->
    checkElement('select[id="issue_status_id"]')->
    checkElement('select[id="issue_priority_id"]')->
    checkElement('select[id="issue_starting_date_month"]')->
    checkElement('select[id="issue_starting_date_day"]')->
    checkElement('select[id="issue_starting_date_year"]')->
    checkElement('select[id="issue_ending_date_month"]')->
    checkElement('select[id="issue_ending_date_day"]')->
    checkElement('select[id="issue_ending_date_year"]')->
    checkElement('select[id="issue_users_list"]')->
    checkElement('select[id="issue_issues_list"]')->
    checkElement('select[id="issue_milestone_id"]')->

    checkElement('select[id="issue_related_issue_list"] option[value="74"]', false)->
    checkElement('select[id="issue_users_list"] option[value="1"]', false)->
    checkElement('select[id="issue_users_list"] option[value="4"]', false)->

    checkElement('select[id="issue_starting_date_month"] option[value="'.$today[1].'"][selected="selected"]')->
    checkElement('select[id="issue_starting_date_day"] option[value="'.$today[2].'"][selected="selected"]')->
    checkElement('select[id="issue_starting_date_year"] option[value="'.$today[0].'"][selected="selected"]')->

  end();

$some_day = explode('-',date('Y-n-d', strtotime('-67 days')));
$browser->click('Save', array('issue' => array(
    'title'           => 'new ticket',
    'description'     => 'new issue for this project',
    'status_id'       => 1,
    'priority_id'     => 1,
    'starting_date'   => array('day' => $some_day[2], 'month' => $some_day[1], 'year' => $some_day[0]),
    'ending_date'     => array('day' => date('d', strtotime('+1 month')), 'month' => date('n', strtotime('+1 month')), 'year' => date('Y', strtotime('+1 month'))),
    'users_list'      => array('3'),
    'issues_list'     => array('51')
  )), array('methos'=>'post'))->
  
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'index')->
  end()->
  click('Last')->
  responseContains('new ticket')->

  get('/en/idProject/3/idIssue/edit/113')->

  with('response')->begin()->
    checkElement('select[id="issue_starting_date_month"] option[value="'.$some_day[1].'"][selected="selected"]')->
    checkElement('select[id="issue_starting_date_day"] option[value="'.$some_day[2].'"][selected="selected"]')->
    checkElement('select[id="issue_starting_date_year"] option[value="'.$some_day[0].'"][selected="selected"]')->
  end()
  ;