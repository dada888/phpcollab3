<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  //click('Groups')->
  get('/en/sfGuardGroup')->

  responseContains('admin')->
  responseContains('user')->

  click('Filter', array('sf_guard_group_filters' =>
                          array( 'name' =>
                                        array(
                                              'text' => 'user'
                                             )
                               )
                       )
       )->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'sfGuardGroup')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('table a:contains("admin")', false)->
    checkElement('table a:contains("user")')->
  end();