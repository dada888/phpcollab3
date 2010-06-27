<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/')->

click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->
  get('/en/idProject/show/3')->

  click('Issues')->
  click('Last')->
  with('response')->begin()->
    checkElement('ul.action li.icon-green', 8)->
  end()->
  
  click('Delete')->
  followRedirect()->
  click('Last')->

  with('response')->begin()->
    checkElement('ul.action li.icon-green', 7)->
  end()
;
