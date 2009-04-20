<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();

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
    checkElement('label:contains("Created at")', false)->
    checkElement('label:contains("Updated at")', false)->
    checkElement('input:contains("Create")', false)->
    checkElement('a[href="/index.php/en/idProject"]')->

    checkElement('input[type="checkbox"][id="project_is_public"][checked="checked"]', false)->
    
  end()
;

$browser->info('Creation of a new project')->

  click('Create a new project', array('project' => array(
    'name'      => 'NewProject',
    'description'      => 'what a beautiful new project!!',
    'is_public'      => 0,
  )))->

  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'show')->
  end()->

  responseContains('NewProject')->
  responseContains('what a beautiful new project!!')
;