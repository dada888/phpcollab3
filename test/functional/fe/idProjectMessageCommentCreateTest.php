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

  click('Leave a comment', array('fd_comment' => array('title' => 'comment title', 'body' => 'comment body: your message rocks!!' )))->
  with('mailer')->begin()->
    checkHeader('Subject', '/fdComment .* created/')->
    checkHeader('To', '/example3@example.com/')->
    checkHeader('To', '/example5@example.com/')->
    checkBody('/comment title/')->
    checkBody('/comment body: your message rocks/')->
  end()->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idMessage')->
    isParameter('action', 'show')->
  end()->

  with('response')->begin()->
    checkElement('h4:contains("comment title")')->
    checkElement('p:contains("comment body: your message rocks!!")')->
  end()
;
