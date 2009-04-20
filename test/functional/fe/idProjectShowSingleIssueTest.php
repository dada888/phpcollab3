<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->inizilizeDatabase();

$browser->

get('/')->
click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->
  
  click('3')->

  click('Issues')->

  click('1')->

  with('response')->begin()->
    isStatusCode(200)->

    checkElement('th:contains("Id")')->
    checkElement('th:contains("Title")')->
    checkElement('th:contains("Description")')->
    checkElement('th:contains("Status")')->
    checkElement('th:contains("Priority")')->
    checkElement('th:contains("Starting date")')->
    checkElement('th:contains("Ending date")')->

    checkElement('td:contains("#1")')->
    checkElement('td:contains("new issue")', 2)->
    checkElement('td:contains("new")')->
    checkElement('td:contains("normal")')->
    checkElement('td:contains("'.date("Y-m-d", time()).'")')->
    checkElement('td:contains("'.date("Y-m-d", strtotime("+10 day")).'")')->
    
  end()
;