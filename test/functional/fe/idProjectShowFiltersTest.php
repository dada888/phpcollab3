<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$project_filters = array();
$project_filters['project_filters']['name'] = '';
$project_filters['project_filters']['is_public'] = '';
$project_filters['project_filters']['created_at'] = array(
                                                          'month' => date("n", strtotime("-1 day")),
                                                          'day' => date("j", strtotime("-1 day")),
                                                          'year' => date("Y", strtotime("-1 day"))
                                                          );

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();


$browser->

get('/')->
click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  get('/en/idProject')->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'index')->
  end()->

  responseContains('Il mio primo progetto')->
  responseContains('Il mio secondo progetto')->
  responseContains('Il mio terzo progetto')->


  with('response')->begin()->
    isStatusCode(200)->
    
    checkElement('th:contains("Id")')->
    checkElement('th:contains("Name")')->
    checkElement('th:contains("Description")')->
    checkElement('th:contains("Public")')->
    checkElement('th:contains("Created at")', false)->
    checkElement('th:contains("Updated at")', false)->

    checkElement('#main #block-tables div.content div.inner table.table tr.odd td a[href="/index.php/en/idProject/show/1"]', 1)->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td a[href="/index.php/en/idProject/show/2"]', 1)->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td a[href="/index.php/en/idProject/show/3"]', 1)->
    
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td a[href="/index.php/en/idProject/edit/1"]', 1)->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td a[href="/index.php/en/idProject/edit/2"]', 1)->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td a[href="/index.php/en/idProject/edit/3"]', 1)->
    
    checkElement('#block-filters form.form table.table th:contains("Name")')->
    checkElement('#block-filters form.form #project_filters_name')->

    checkElement('#block-filters form.form table.table th:contains("Public/Private")')->
    checkElement('#block-filters form.form table.table td #project_filters_is_public')->

    checkElement('#block-filters form.form table.table th:contains("Created after")')->
    checkElement('#block-filters form.form table.table td #project_filters_created_at_month')->
    checkElement('#block-filters form.form table.table td #project_filters_created_at_day')->
    checkElement('#block-filters form.form table.table td #project_filters_created_at_year')->

    checkElement('#block-filters form.form label:contains("Updated at")', false)->
    checkElement('#block-filters form.form label:contains("Description")', false)->
  end()
;

$browser->info('Testing the right behaviout of the filters form')->

  info('1) Returns an error when used a project name too long')->
  click('Filter', array('project_filters' => array(
    'name'      => '12345678901234567890123456789012345678901234567890123456789012345',
  )))->

  responseContains('Project name 12345678901234567890123456789012345678901234567890123456789012345 is too long (max 64 chars).')->

  info('2) Returns the right list of projects containg the word "primo" in ther names')->
  click('Filter', array('project_filters' => array(
    'name'      => 'primo',
  )))->

  with('response')->begin()->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio primo progetto")')->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio secondo progetto")', false)->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio terzo progetto")', false)->
  end()->

  click('Reset')->

  info('2) Returns the right list of public projects')->
  click('Filter', array('project_filters' => array(
    'is_public' => '1'
  )))->

  with('response')->begin()->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio primo progetto")', false)->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio secondo progetto")', false)->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio terzo progetto")')->
  end()->

  click('Reset')->

  info('2) Returns the right list of projects based on the created_at parameter')->
  click('Filter', $project_filters)->
  with('response')->begin()->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio primo progetto")')->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio secondo progetto")', false)->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio terzo progetto")', false)->
  end()
;

$project_filters = array();
$project_filters['project_filters']['name'] = '';
$project_filters['project_filters']['is_public'] = '';
$project_filters['project_filters']['created_at'] = array(
                                                          'month' => date("n", strtotime("-2 day")),
                                                          'day' => date("j", strtotime("-2 day")),
                                                          'year' => date("Y", strtotime("-2 day"))
                                                          );
$browser->
click('Reset')->
click('Filter', $project_filters)->
  with('response')->begin()->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio primo progetto")')->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio secondo progetto")')->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio terzo progetto")', false)->
  end()
;


$project_filters = array();
$project_filters['project_filters']['name'] = '';
$project_filters['project_filters']['is_public'] = '';
$project_filters['project_filters']['created_at'] = array(
                                                          'month' => date("n", strtotime("-3 day")),
                                                          'day' => date("j", strtotime("-3 day")),
                                                          'year' => date("Y", strtotime("-3 day"))
                                                          );

$browser->
click('Reset')->
click('Filter', $project_filters)->
  with('response')->begin()->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio primo progetto")')->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio secondo progetto")')->
    checkElement('#main #block-tables div.content div.inner table.table tr.odd td:contains("Il mio terzo progetto")')->
  end()
;