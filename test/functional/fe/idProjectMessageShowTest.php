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

  with('response')->begin()->
    checkElement('div.content h2:contains("Primo messaggio")')->
    checkElement('div.message p:contains("Body primo messaggio")')->

    checkElement('form input[type="submit"][value="Leave a comment"]')->
    checkElement('form input[name="fd_comment[title]"]')->
    checkElement('form textarea[name="fd_comment[body]"]')->
    checkElement('form input[name="fd_comment[model]"][type="hidden"]')->
    checkElement('form input[name="fd_comment[model_field]"][type="hidden"]')->
    checkElement('form input[name="fd_comment[profile_id]"][type="hidden"]')->

    checkElement('h4:contains("pippo")')->
    checkElement('p:contains("pippo pippo poivnonjoifwe ijewjpfjpw ....")')->
    checkElement('div:contains("by prog (puser) prog")')->
    checkElement('div:contains("by Mario (user) Wage")')->

    checkElement('.pagenation a[href~="idProject/2/idMessage/show/1?page=2"]', 3)->
  end()
;
