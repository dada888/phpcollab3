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

  with('response')->begin()->
    checkElement('ul li.icon-comment', 2)->
  end()->

  click('Delete')->

  with('mailer')->begin()->
    checkHeader('Subject', '/Message .* deleted/')->
    checkHeader('To', '/example3@example.com/')->
    checkHeader('To', '/example5@example.com/')->
    checkBody('/Hi, this is your collab installation mail system/')->
    checkBody('/Log: message has been deleted/')->
    checkBody('/has been deleted by puser on/')->
  end()->
  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'idMessage')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    checkElement('ul li.icon-comment', 1)->
  end()
;