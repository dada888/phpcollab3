<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

/**
 * 1) dove ci sono milestone esiste anche una roadmap,
 *
 * 2) dove non ci sono milestone non deve esserci neanche una roadmap
 *
 */

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->
  get('/en/idProject/show/2/roadmap')->
  click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
  followRedirect()->
  with('response')->begin()->
    isStatusCode(404)->
  end()->

  get('/')->
  click('Logout');

$browser->
  get('/')->
  click('Login', array('signin' => array('username' => 'userp2', 'password' => 'userp2')))->
  followRedirect()->

  click('Projects')->

  click('Il mio secondo progetto')->

  //click('Roadmap')->
  get('/en/idProject/show/2/roadmap')->

  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'roadmap')->
    isParameter('id', '2')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->

    //checkElement('h1:contains("Roadmap")')->

    checkElement('h2:contains("Milestone: first iteration")')->
    checkElement('div#first_iteration td:contains("p2 first iterazione issue 1")')->
    checkElement('div#first_iteration td:contains("p2 first iterazione issue 2")')->
    checkElement('div#first_iteration td:contains("description")', false)->

    checkElement('h2:contains("Milestone: second iteration")')->
    checkElement('div#second_iteration td:contains("p2 second iterazione issue 1")')->
    checkElement('div#second_iteration td:contains("p2 second iterazione issue 2")')->
    checkElement('div#second_iteration td:contains("p2 second iterazione issue 3")')->
    checkElement('div#second_iteration td:contains("description")', false)->
  end()->

  click('Dashboard')->

  click('Logout')->
  followRedirect()->

  click('Login', array('signin' => array('username' => 'user', 'password' => 'user')))->
  
  get('/en/idProject/show/1')->
  with('response')->begin()->
    checkElement('h1:contains("Roadmap")', false)->
  end()
;