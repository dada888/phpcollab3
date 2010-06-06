<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());

$browser->
  
  get('/en/login')->
  with('request')->begin()->
    isParameter('module', 'sfGuardAuth')->
    isParameter('action', 'signin')->
  end()->

  with('response')->begin()->
    isStatusCode(401)->

    checkElement('a[href="/index.php/en/login"]', 'Signin')->

    checkElement('form label:contains("Username")')->
    checkElement('form label:contains("Password")')->
    checkElement('form label:contains("Remember")')->


    checkElement('form input[type="checkbox"][id="signin_remember"]')->
    checkElement('form input[type="password"][id="signin_password"]')->
    checkElement('form input[type="text"][id="signin_username"]')->
    
    //checkElement('div.navform div.left a[href="/index.php/en/request_password"]', 'Forgot your password?')->
    checkElement('form input[type="submit"][value="Login"]')->
    
  end()
;