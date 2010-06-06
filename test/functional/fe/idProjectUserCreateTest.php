<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();



$browser->

  get('/sfGuardUser')->
  with('response')->begin()->
      isStatusCode(404)->
  end()->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->
  
  click('Users')->

  click('Create new user')->

  with('request')->begin()->
    isParameter('module', 'sfGuardUser')->
    isParameter('action', 'new')->
  end()->

  with('response')->begin()->
    checkElement('input[type="text"][id="sf_guard_user_username"]')->
    checkElement('input[type="password"][id="sf_guard_user_password"]')->
    checkElement('input[type="password"][id="sf_guard_user_password_again"]')->

    checkElement('input[type="text"][id="sf_guard_user_Profile_first_name"]')->
    checkElement('input[type="text"][id="sf_guard_user_Profile_last_name"]')->
    checkElement('input[type="text"][id="sf_guard_user_Profile_email"]')->
    checkElement('input[type="checkbox"][id="sf_guard_user_is_active"]')->
    checkElement('input[type="checkbox"][id="sf_guard_user_is_super_admin"]')->
    checkElement('select[id="sf_guard_user_groups_list"]')->
    checkElement('select[id="sf_guard_user_permissions_list"]')->
  end();



$browser->click('Save', array('sf_guard_user' => array(
                                                          'username' => 'brigido',
                                                          'password' => 'brigido',
                                                          'password_again' => 'brigido',
                                                          'Profile' => array(
                                                                              'first_name' => 'Flavio',
                                                                              'last_name' => 'Brigidini',
                                                                              'email' => 'brigidini@examople.com',

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

  responseContains('The item was created successfully.')
  
;
