<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Time')->

  with('request')->begin()->
    isParameter('module', 'idLogtime')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('#content .menu:contains("Name")')->
    checkElement('#content .menu:contains("Description")')->
    checkElement('#content .menu:contains("Date")')->
    checkElement('#content .menu:contains("Time")')->
    checkElement('#content .menu:contains("Issue/Project")')->

    checkElement('li:contains("'.strftime('%B %e %Y', strtotime('today')).'")')->
    checkElement('li a[href="/index.php/en/idLogtime/edit/1"]', 'Edit')->
    checkElement('li a[href="/index.php/en/idProject/3/idIssue/show/1"]', '#1 new issue')->
    checkElement('li:contains("Prog P.")')->
    checkElement('li:contains("12")')->
    checkElement('li:contains("Edit")')->
    checkElement('li:contains("Delete")')->
  end()

  ;
