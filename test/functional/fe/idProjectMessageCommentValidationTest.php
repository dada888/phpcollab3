<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->

  click('Projects')->
  click('Il mio secondo progetto')->
  click('Discussions')->
  click('Primo messaggio')->

  with('request')->begin()->
    isParameter('module', 'idMessage')->
    isParameter('action', 'show')->
  end()->

  click('Leave a comment', array('fd_comment' => array('title' => '', 'body' => 'comment body: your message rocks!!' )))->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idMessage')->
    isParameter('action', 'show')->
  end()->

  with('response')->begin()->
    checkElement('li:contains("Title is mandatory")')->
  end()
;
