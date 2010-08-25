<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

  $browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->

  followRedirect()->
  
  click('puser')->

  with('request')->begin()->
    isParameter('module', 'idProfile')->
    isParameter('action', 'edit')->
  end()->

  click('Save', array('sf_guard_user' => array(
                                                          'username' => '',
                                                          'password' => 'mario2',
                                                          'password_again' => 'mario2',
                                                          'Profile' => array(
                                                                              'first_name' => 'mariotto',
                                                                              'last_name' => 'mariotti',
                                                                              'email' => 'mariotti@examople.com',
                                                                            )
                                                        )
                        )
       , array('method' => 'post'))->
  with('response')->begin()->
    checkElement('body:contains("Username: Required.")')->
  end()->

  click('Save', array('sf_guard_user' => array(
                                                          'username' => 'pippo',
                                                          'password' => 'mario2',
                                                          'password_again' => 'mario2',
                                                          'Profile' => array(
                                                                              'first_name' => 'mariotto',
                                                                              'last_name' => 'mariotti',
                                                                              'email' => 'mariotti@examople.com',
                                                                            )
                                                        )
                        )
       , array('method' => 'post'))->
  with('response')->begin()->
    checkElement('body:contains("Username: Invalid.")')->
  end()->

  click('Save', array('sf_guard_user' => array(
                                                          'username' => 'puser',
                                                          'password' => 'jfcqweo',
                                                          'password_again' => 'hhhhhhh',
                                                          'Profile' => array(
                                                                              'first_name' => 'mariotto',
                                                                              'last_name' => 'mariotti',
                                                                              'email' => 'mariotti@examople.com',
                                                                            )
                                                        )
                        )
       , array('method' => 'post'))->
  with('response')->begin()->
    checkElement('body:contains("The two passwords must be the same.")')->
  end()->

  click('Save', array('sf_guard_user' => array(
                                                          'username' => 'puser',
                                                          'password' => 'pippo',
                                                          'password_again' => 'pippo',
                                                          'Profile' => array(
                                                                              'first_name' => 'mariotto',
                                                                              'last_name' => 'mariotti',
                                                                              'email' => 'mariotti__ncjuenooewc@',
                                                                            )
                                                        )
                        )
       , array('method' => 'post'))->
  with('response')->begin()->
    checkElement('body:contains("Invalid email address")')->
  end()
;
