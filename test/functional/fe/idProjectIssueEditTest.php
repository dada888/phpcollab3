<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new idDoctrineTestBrowser());
$browser->initializeDatabase();


$issue_parameters = array('issue' => array(
                                'title'               => 'new issue',
                                'description'         => 'new issue',
                                'status_id'           => 1,
                                'priority_id'         => 1,
                                'starting_date'       => array('day' => date('d', strtotime('today')), 'month' => date('m', strtotime('today')), 'year' => date('Y', strtotime('today'))),
                                'ending_date'         => array('day' => date('d', strtotime('+1 month')), 'month' => date('m', strtotime('+1 month')), 'year' => date('Y', strtotime('+1 month'))),
                                'users_list'          => array('3'),
                                'issues_list'  => array(5)
                                      )
                    );

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

  click('Edit', array(), array('position'=>1))->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'edit')->
    isParameter('issue_id', '1')->
    isParameter('project_id', '3')->
  end()->

  responseContains('Tracker')->

  with('response')->begin()->
    checkElement('select[id="issue_tracker_id"]')->
  end()->

  with('response')->begin()->
    checkElement('select[id="issue_related_list"] option[value="1"]', false)->
  end();


$browser->click('Save', array('issue' => array(
    'title'           => 'new ticket up',
    'description'     => 'new issue for this project up',
    'status_id'       => 1,
    'priority_id'     => 1,
    'starting_date'   => array('day' => date('d', strtotime('today')), 'month' => date('m', strtotime('today')), 'year' => date('Y', strtotime('today'))),
    'ending_date'     => array('day' => date('d', strtotime('+1 month')), 'month' => date('m', strtotime('+1 month')), 'year' => date('Y', strtotime('+1 month'))),
    'users_list'      => array('3')
  )), array('methos'=>'post'))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'index')->
  end()->

  responseContains('new ticket up')->
  responseContains('new issue for this project up')->

  click('Dashboard')->

  click('Logout')->
  followRedirect()->

  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Projects')->

  click('Il mio terzo progetto')->

  click('Issues')->

  click('Edit', array(), array('position'=>2))->

  click('Save', array('issue' => array('issues_list' => array ('1'))))->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'index')->
  end()->

  click('Dashboard')->

  click('Logout')->
  followRedirect()->

  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Projects')->

  click('Il mio terzo progetto')->

  click('Issues')->

  click('#1')->

  click('Edit')->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'edit')->
    isParameter('issue_id', '1')->
  end()->

  with('response')->begin()->
    checkElement('select#issue_issues_list option[value="2"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="3"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="4"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="5"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="12"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="13"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="14"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="16"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="17"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="18"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="19"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="20"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="21"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="22"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="23"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="24"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="25"][selected="selected"]')->
 end()->

  deSelectOption('issue_issues_list', '2')->
  deSelectOption('issue_issues_list', '3')->
  deSelectOption('issue_issues_list', '4')->
  deSelectOption('issue_issues_list', '12')->
  deSelectOption('issue_issues_list', '13')->
  deSelectOption('issue_issues_list', '14')->
  deSelectOption('issue_issues_list', '15')->
  deSelectOption('issue_issues_list', '16')->
  deSelectOption('issue_issues_list', '17')->
  deSelectOption('issue_issues_list', '18')->
  deSelectOption('issue_issues_list', '19')->
  deSelectOption('issue_issues_list', '20')->
  deSelectOption('issue_issues_list', '21')->
  deSelectOption('issue_issues_list', '22')->
  deSelectOption('issue_issues_list', '23')->
  deSelectOption('issue_issues_list', '24')->
  deSelectOption('issue_issues_list', '25')->

  click('Save',$issue_parameters, array('methos'=>'post'))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'index')->
  end()->

  click('#1')->

  click('Edit')->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'edit')->
    isParameter('issue_id', '1')->
  end()->

  with('response')->begin()->
    checkElement('select#issue_issues_list option[value="5"][selected="selected"]')->
    checkElement('select#issue_issues_list option[value="18"][selected="selected"]', false)->
  end()
;


$browser->
  get('/en/idProject/3/idIssue/edit/27')->
    click('Save',array('issue' => array(
    'title'           => 'new issue',
    'description'     => 'new issue',
    'status_id'       => 1,
    'priority_id'     => 1,
    'starting_date'   => array('day' => date('d', strtotime('today')), 'month' => date('m', strtotime('today')), 'year' => date('Y', strtotime('today'))),
    'ending_date'     => array('day' => date('d', strtotime('+1 month')), 'month' => date('m', strtotime('+1 month')), 'year' => date('Y', strtotime('+1 month'))),
    'users_list'      => array('3'),
    'issues_list'      => array('28'))),
    array('methos'=>'post'))->

  followRedirect()->

  get('en/idProject/3/idIssue/show/27')->

  with('response')->begin()->
    checkElement('div#related-issue tr td a[href="/index.php/en/idProject/3/idIssue/show/28"]', '#28')->
  end()
;

$browser->
  get('/en/idProject/3/idIssue/edit/27')->
    click('Save',array('issue' => array(
    'title'           => 'new issue',
    'description'     => 'new issue',
    'status_id'       => 1,
    'priority_id'     => 1,
    'starting_date'   => array('day' => date('d', strtotime('today')), 'month' => date('m', strtotime('today')), 'year' => date('Y', strtotime('today'))),
    'ending_date'     => array('day' => date('d', strtotime('+1 month')), 'month' => date('m', strtotime('+1 month')), 'year' => date('Y', strtotime('+1 month'))),
    'users_list'      => array('3'),
    'issues_list'      => array('28'),
    'estimated_time' => '0.78')),
    array('methos'=>'post'))->

  followRedirect()->

  get('/en/idProject/3/idIssue/show/27')->

  with('response')->begin()->
    checkElement('td:contains("0.78")')->
  end()
;

$browser->
  get('/en/idProject/1/idIssue/edit/110')->
    click('Save',array('issue' => array(
    'title'           => 'new issue',
    'description'     => 'new issue',
    'status_id'       => 3,
    'priority_id'     => 1,
    'starting_date'   => array('day' => date('d', strtotime('today')), 'month' => date('m', strtotime('today')), 'year' => date('Y', strtotime('today'))))),
    array('methos'=>'post'))->

  followRedirect()->

  get('/en/idProject/1/idIssue/edit/110')->

  with('response')->begin()->
    checkElement('#issue_ending_date_month option[selected="selected"]','/'.date('m',strtotime('today')).'/')->
    checkElement('#issue_ending_date_year option[selected="selected"]','/'.date('Y',strtotime('today')).'/')->
    checkElement('#issue_ending_date_day option[selected="selected"]','/'.date('d',strtotime('today')).'/')->
  end()
;

$browser->
  get('/en/idProject/1/idIssue/edit/110')->
    click('Save',array('issue' => array(
    'title'           => 'new issue',
    'description'     => 'new issue',
    'status_id'       => 1,
    'priority_id'     => 1,
    'starting_date'   => array('day' => date('d', strtotime('today')), 'month' => date('m', strtotime('today')), 'year' => date('Y', strtotime('today'))))),
    array('methos'=>'post'))->

  followRedirect()->

  get('/en/idProject/1/idIssue/edit/110')->

  with('response')->begin()->
    checkElement('#issue_ending_date_month option[selected="selected"][value=""]')->
    checkElement('#issue_ending_date_year option[selected="selected"][value=""]')->
    checkElement('#issue_ending_date_day option[selected="selected"][value=""]')->
  end()
;