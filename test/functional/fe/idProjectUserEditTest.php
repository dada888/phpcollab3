<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();



  $browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->
  
  click('Users')->

  click('nopuser')->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'edit')->
  end()->

  click('Save modification', array('sf_guard_user' => array(
                                                          'username' => 'nopuser',
                                                          'password' => 'mario',
                                                          'password_again' => 'mario',
                                                          'Profile' => array(
                                                                              'first_name' => 'mario',
                                                                              'last_name' => 'mariotti',
                                                                              'email' => 'mariotti@examople.com',
                                                                            ),
                                                          'is_active' => 'on',
                                                          'groups_list' => array('2'),
                                                          'permissions_list' => array('2')
                                                        )
                        )
       , array('method' => 'post'))->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'edit')->
  end()->

  responseContains('The item was updated successfully.')
  
;
