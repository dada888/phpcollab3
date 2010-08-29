<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->
  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->
  click('Projects')->
  click('Il mio primo progetto')->
  get('/en/idProject/1/settings')->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'settings')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('ul li a[href="#overview"]', 'Overview')->
    checkElement('ul li a[href="#staff"]', 'Staff')->

    checkElement('#overview input[id="project_name"][value="Il mio primo progetto"]')->
    checkElement('#overview textarea[id="project_description"]', '/Il primo progetto creato con il plugin idProjectManagementPlugin/')->
    checkElement('#staff select option', 7)->
  end();

$browser->info('Edit prject overview')->
  setField('project[name]', 'new name')->
  setField('project[description]', 'great description!')->
  click('input[id="update-overview"]')->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('.notice', '/Project overview updated successfully/')->
  end();

$browser->info('Edit prject staff')->
  setField('project[users_list]', array(3, 4, 5))->
  click('input[id="update-staff"]')->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('.notice', '/Project staff updated successfully/')->
    checkElement('select option[selected="selected"][value="5"]')->
    checkElement('select option[selected="selected"][value="3"]')->
    checkElement('select option[selected="selected"][value="4"]')->
  end();

$browser->info('Edit prject trackers')->
  setField('project[trackers_list]', array(1, 2))->
  click('input[id="update-tracker"]')->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('.notice', '/Project trackers updated successfully/')->
    checkElement('select option[selected="selected"][value="1"]')->
    checkElement('select option[selected="selected"][value="2"]')->
  end();
