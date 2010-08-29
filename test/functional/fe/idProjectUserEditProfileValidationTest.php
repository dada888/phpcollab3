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
                                               'first_name' => 'mariotto',
                                               'last_name' => 'mariotti',
                                               'email_address' => 'mariotti@examople.com')),
                                         array('method' => 'post'))->
  with('response')->begin()->
    checkElement('body:contains("Username: Required.")')->
  end()->

  click('Save', array('sf_guard_user' => array(
                                                'username' => 'admin',
                                                'password' => 'mario2',
                                                'password_again' => 'mario2',
                                                'first_name' => 'mariotto',
                                                'email_address' => 'mariotti@examople.com'
                                              )
                        )
       , array('method' => 'post'))->

  with('form')->begin()->
    hasErrors(true)->
  end()->

  with('response')->begin()->
    checkElement('body:contains("Username: An object with the same "username" already exist.")')->
  end()->

  click('Save', array('sf_guard_user' => array(
                                                'username' => 'puser',
                                                'password' => 'jfcqweo',
                                                'password_again' => 'hhhhhhh',
                                                'first_name' => 'mariotto',
                                                'last_name' => 'mariotti',
                                                'email_address' => 'mariotti@examople.com',
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
                                                'first_name' => 'mariotto',
                                                'last_name' => 'mariotti',
                                                'email_address' => 'mariotti__ncjuen@',
                                              )
                        )
       , array('method' => 'post'))->
  with('response')->begin()->
    checkElement('body:contains("Email Address is invalid")')->
  end()
;
