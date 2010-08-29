<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->
  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->
  click('Projects')->
  click('Gant chart project')->
  click('Settings', array(), array('position' => 2))->
  
  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'settings')->
  end()->

  with('response')->begin()->
    checkElement('ul li a[href="#usersroles"]','Users roles')->

    checkElement('#usersroles form', 2)->
    checkElement('#usersroles form:contains("puser")')->
    checkElement('#usersroles form:contains("example7@example.com")')->
    checkElement('#usersroles form[id="project_user_1"] select option', 3)->
    checkElement('#usersroles form[id="project_user_1"] select option[selected="selected"][value="2"]', 'developer')->
    checkElement('#usersroles form[id="project_user_1"] select option[value="3"]', 'project manager')->
    checkElement('#usersroles form[id="project_user_1"] select option[value="4"]', 'customer')->
  end()->

  click('Save' ,array('project_user' => array('role' => '3')), array('position' => 4))->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'settings')->
  end()->

  with('response')->begin()->
    checkElement('ul li a[href="#usersroles"]','Users roles')->

    checkElement('.notice', '/Modification applied with success/')->
    checkElement('#usersroles form', 2)->
    checkElement('#usersroles form[id="project_user_0"] select option', 3)->
    checkElement('#usersroles form[id="project_user_0"] select option[value="2"]', 'developer')->
    checkElement('#usersroles form[id="project_user_0"] select option[selected="selected"][value="3"]', 'project manager')->
    checkElement('#usersroles form[id="project_user_0"] select option[value="4"]', 'customer')->
  end()->
  click('Save' ,array('project_user' => array('role' => '1')), array('position' => 4))->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'settings')->
  end()->

  with('response')->begin()->
    checkElement('ul li a[href="#usersroles"]','Users roles')->

    checkElement('.error', '/There are errors in the form submitted/')->
    checkElement('#usersroles form', 2)->
    checkElement('#usersroles form[id="project_user_0"] select option', 3)->
    checkElement('#usersroles form[id="project_user_0"] select option[value="2"]', 'developer')->
    checkElement('#usersroles form[id="project_user_0"] select option[selected="selected"][value="3"]', 'project manager')->
    checkElement('#usersroles form[id="project_user_0"] select option[value="4"]', 'customer')->
  end()
;