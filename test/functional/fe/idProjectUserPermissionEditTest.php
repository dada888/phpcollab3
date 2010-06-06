<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/en/sfGuardPermission')->
  click('Signin')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  //click('Permissions')->
  get('/en/sfGuardPermission')->

  click('user')->

  with('request')->begin()->
    isParameter('module', 'sfGuardPermission')->
    isParameter('action', 'edit')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->

    checkElement('label:contains("Id")', false)->
    checkElement('label:contains("Name")')->
    checkElement('label:contains("Description")')->
    checkElement('label:contains("Groups")')->
    checkElement('label:contains("Users")')->

    checkElement('a:contains("Cancel")')->
    checkElement('a:contains("Delete")')->
    checkElement('input[type="submit"][value="Save modification"]')->
  end()->

  click('Save modification', array('sf_guard_permission' => array(
    'name'      => 'user',
    'description'      => 'user permission 2',
    'groups_list'      => array('2'),
    'users_list'      => array('2'),
  )))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'sfGuardPermission')->
    isParameter('action', 'edit')->
  end()->

  with('response')->begin()->
    checkElement('li:contains("already exist")', false)->
  end()->

  responseContains('The item was updated successfully.')->
  responseContains('user permission 2')
;
