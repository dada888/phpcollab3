<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/en/idProject/edit/1')->
click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
  followRedirect()->
  with('response')->begin()->
    isStatusCode('403')->
  end()->

click('Logout')->

get('/')->
click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  get('/en/idProject/edit/1')->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'edit')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->

    checkElement('label:contains("Name")')->
    checkElement('label:contains("Description")')->

    checkElement('select[id="project_trackers_list"]')->
   info('Update a project')->

    click('Update the project', array('project' => array(
      'name'      => 'Il mio primo progetto updatato',
      'description'      => 'Il primo 222 progetto creato con il plugin idProjectManagementPlugin')))->

  end();

    $browser->
    get('/en/idProject/show/1')->
      with('request')->begin()->
        isParameter('module', 'idProject')->
        isParameter('action', 'show')->
      end()->

      with('response')->begin()->
        checkElement('div:contains("Il primo 222 progetto creato con il plugin idProjectManagementPlugin")')->
      end()
;
