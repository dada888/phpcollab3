<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->
  
  click('Groups')->

  click('Create new group')->

  with('request')->begin()->
    isParameter('module', 'sfGuardGroup')->
    isParameter('action', 'new')->
  end()->

  click('Save', array('sf_guard_group' => array(
    'name'      => 'new group',
    'description'      => 'group for new people',
    'permissions_list'      => array('2'=>'user'),
    'users_list'      => array('2'=>'user'),
  )))->

  with('request')->begin()->
    isParameter('module', 'sfGuardGroup')->
    isParameter('action', 'create')->
  end()->

  responseContains('new group')->
  responseContains('group for new people')
;
