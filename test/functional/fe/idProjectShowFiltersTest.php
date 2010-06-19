<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$project_filters = array();
$project_filters['project_filters']['name'] = '';
$project_filters['project_filters']['created_at'] = array(
                                                          'month' => date("n", strtotime("-1 day")),
                                                          'day' => date("j", strtotime("-1 day")),
                                                          'year' => date("Y", strtotime("-1 day"))
                                                          );

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


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
    
    checkElement('a[href*="en/idProject/show/1"]', 1)->
    checkElement('a[href*="en/idProject/show/2"]', 1)->
    checkElement('a[href*="en/idProject/show/3"]', 1)->
    
    checkElement('form #project_filters_name')->

    checkElement('form #project_filters_created_at_month')->
    checkElement('form #project_filters_created_at_day')->
    checkElement('form #project_filters_created_at_year')->
  end()
;

$browser->info('Testing the right behaviour of the filters form')->

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
    checkElement('#project a:contains("Il mio primo progetto")')->
    checkElement('#project a:contains("Il mio secondo progetto")', false)->
    checkElement('#project a:contains("Il mio terzo progetto")', false)->
  end()->

  click('Reset')->

  info('3) Returns the right list of projects based on the created_at parameter')->
  click('Filter', $project_filters)->
  with('response')->begin()->
    checkElement('#project a:contains("Il mio primo progetto")', false)->
    checkElement('#project a:contains("Il mio secondo progetto")', false)->
    checkElement('#project a:contains("Il mio terzo progetto")', false)->
  end()
;

$project_filters = array();
$project_filters['project_filters']['name'] = '';
$project_filters['project_filters']['created_at'] = array(
                                                          'month' => date("n", strtotime("-2 day")),
                                                          'day' => date("j", strtotime("-2 day")),
                                                          'year' => date("Y", strtotime("-2 day"))
                                                          );
$browser->
click('Reset')->
click('Filter', $project_filters)->
  with('response')->begin()->
    checkElement('#project a:contains("Il mio primo progetto")', false)->
    checkElement('#project a:contains("Il mio secondo progetto")')->
    checkElement('#project a:contains("Il mio terzo progetto")', false)->
  end()
;


$project_filters = array();
$project_filters['project_filters']['name'] = '';
$project_filters['project_filters']['created_at'] = array(
                                                          'month' => date("n", strtotime("-3 day")),
                                                          'day' => date("j", strtotime("-3 day")),
                                                          'year' => date("Y", strtotime("-3 day"))
                                                          );

$browser->
click('Reset')->
click('Filter', $project_filters)->
  with('response')->begin()->
    checkElement('#project a:contains("Il mio primo progetto")')->
    checkElement('#project a:contains("Il mio quarto progetto")',false)->
    checkElement('#project a:contains("Il mio secondo progetto")')->
    checkElement('#project a:contains("Il mio terzo progetto")')->
  end()
;