<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->
get('/en/idProject/new')->

click('Login', array('signin' => array('username' => 'nouser', 'password' => 'nouser')))->

  with('request')->begin()->
    isParameter('module', 'sfGuardAuth')->
    isParameter('action', 'signin')->
  end()->

click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
  followRedirect()->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

click('Logout')->
followRedirect()->

click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'new')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->

    checkElement('label:contains("Id")', false)->
    checkElement('label:contains("Name")')->
    checkElement('label:contains("Description")')->
    checkElement('label:contains("Public")')->
    checkElement('label:contains("Starting date")')->
    checkElement('label:contains("End date")')->
    checkElement('label:contains("Updated at")', false)->
    checkElement('input:contains("Create")', false)->
    checkElement('a[href="/index.php/en/idProject"]')->

    checkElement('select[id="project_users_list"] option[value="1"]', false)->

    checkElement('input[type="checkbox"][id="project_is_public"][checked="checked"]', false)->
    
  end()
;

$browser->info('Creation of a new project')->

  click('Create a new project', array('project' => array(
    'name'      => 'NewProject',
    'description'      => 'what a beautiful new project!!'
  )))->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'show')->
  end()->

  responseContains('NewProject')->
  responseContains('what a beautiful new project!!')->

  get('/')->
  click('Logout')->
  followRedirect()
;

$browser->
click('Login', array('signin' => array('username' => 'pmanager', 'password' => 'pmanager')))->
followRedirect()->

get('/en/idProject/new')->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'new')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->

    checkElement('label:contains("Id")', false)->
    checkElement('label:contains("Name")')->
    checkElement('label:contains("Description")')->
    checkElement('label:contains("Public")')->
    checkElement('label:contains("Starting date")')->
    checkElement('label:contains("End date")')->
    checkElement('label:contains("Updated at")', false)->
    checkElement('input:contains("Create")', false)->
  end()
;

$browser->info('Creation of a new project')->

  click('Create a new project', array('project' => array(
    'name'              => 'NewProject2',
    'description'       => 'what a beautiful new project2!!',
    'users_list'        => array('7')
  )))->

  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'show')->
  end()->

  responseContains('NewProject2')->
  responseContains('what a beautiful new project2!!')
;