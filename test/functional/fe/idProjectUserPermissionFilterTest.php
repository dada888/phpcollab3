<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();


$browser->

get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Permissions')->

  responseContains('admin')->
  responseContains('user')->

  click('Filter', array('sf_guard_permission_filters' =>
                          array( 'name' =>
                                        array(
                                              'text' => 'user'
                                             )
                               )
                       )
       )->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'sfGuardPermission')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('a:contains("admin")', false)->
    checkElement('a:contains("user")')->
  end();