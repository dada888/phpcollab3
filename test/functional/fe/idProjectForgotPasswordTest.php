<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->
  get('/')->
  click('Forgot your password?')->
  with('request')->begin()->
    isParameter('module', 'sfGuardForgotPassword')->
    isParameter('action', 'index')->
  end()->

  setField('forgot_password[email_address]', 'example2@example.com')->
  click('Request')->
  with('mailer')->begin()->
    checkHeader('Subject', '/Forgot Password Request for user/')->
    checkHeader('To', '/example2@example.com/')->
    checkBody('/clicking the below link which is only valid for 24 hours/')->
  end()
;

$fps = Doctrine::getTable('sfGuardForgotPassword')->findAll();

$browser->
  get('/guard/forgot_password/'.$fps[0]->unique_key)->
  with('request')->begin()->
    isParameter('module', 'sfGuardForgotPassword')->
    isParameter('action', 'change')->
  end()->

  setField('sf_guard_user[password]', 'newone')->
  setField('sf_guard_user[password_again]', 'newone')->
  click('Change')->
  with('form')->begin()->
    hasErrors(false)->
  end()->
  with('mailer')->begin()->
    checkHeader('Subject', '/New Password for user/')->
    checkBody('/Below you will your username and new password/')->
    checkBody('/Username: user/')->
    checkBody('/Password: newone/')->
  end()->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'sfGuardAuth')->
    isParameter('action', 'signin')->
  end()->

  with('response')->begin()->
    isStatusCode(401)->
    checkElement('.notice', '/Password updated successfully!/')->
  end()->

  click('Login', array('signin' => array('username' => 'user', 'password' => 'newone')))->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'idDashboard')->
    isParameter('action', 'index')->
  end();