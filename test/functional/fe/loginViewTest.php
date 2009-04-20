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

    checkElement('div#user-navigation ul li a[href="/index.php/en/login"]', 'Signin')->

    checkElement('div.group div.left label:contains("Username")')->
    checkElement('div.group div.left label:contains("Password")')->
    checkElement('div.group div.left label:contains("Remember")')->


    checkElement('div.group div.right input[type="checkbox"][id="signin_remember"]')->
    checkElement('div.group div.right input[type="password"][id="signin_password"]')->
    checkElement('div.group div.right input[type="text"][id="signin_username"]')->
    
    checkElement('div.navform div.left a[href="/index.php/en/request_password"]', 'Forgot your password?')->
    checkElement('div.navform div.right input[type="submit"][value="Login"]')->
    
  end()
;