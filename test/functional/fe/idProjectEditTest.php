<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();

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
    checkElement('label:contains("Public")')->

   info('Update a project')->

    click('Update the project', array('project' => array(
      'name'      => 'Il mio primo progetto updatato',
      'description'      => 'Il primo progetto creato con il plugin idProjectManagmentPlugin',
      'is_public'      => 0,
    )))->

  end();

    $browser->
    get('/en/idProject/show/1')->
      with('request')->begin()->
        isParameter('module', 'idProject')->
        isParameter('action', 'show')->
      end()->

      with('response')->begin()->
        checkElement('td:contains("'.date("Y-m-d", strtotime("-1 day")).'")')->
        checkElement('td:contains("'.date("Y-m-d H:", time()).'")')->
      end()
;
