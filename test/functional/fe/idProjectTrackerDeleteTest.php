<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/')->

click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

  followRedirect()->

  //click('Trackers')->
  get('/en/idTrackers')->

  with('response')->begin()->
    checkElement('td:contains("user story")')->
  end()->

  click('Delete')->

 followRedirect()->

 with('response')->begin()->
    checkElement('td:contains("user story")', false)->
    checkElement('td:contains("Bug")')->
    checkElement('td:contains("Task")')->
  end()
;
