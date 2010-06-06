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
  
  click('Create new permission')->

  with('request')->begin()->
    isParameter('module', 'sfGuardPermission')->
    isParameter('action', 'new')->
  end()->

  click('Save', array('sf_guard_permission' => array(
    'name'      => 'new permission',
    'description'      => 'permission for new people',
    'groups_list'      => array('2'=>'user'),
    'users_list'      => array('2'=>'user'),
  )))->

  with('request')->begin()->
    isParameter('module', 'sfGuardPermission')->
    isParameter('action', 'create')->
  end()->

  responseContains('new permission')->
  responseContains('permission for new people')
;
