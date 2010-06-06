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

    checkElement('div#comment_form input[type="submit"][value="Leave a comment"]')->
    checkElement('div#comment_form input[name="fd_comment[title]"]')->
    checkElement('div#comment_form textarea[name="fd_comment[body]"]')->
    checkElement('div#comment_form input[name="fd_comment[model]"][type="hidden"]')->
    checkElement('div#comment_form input[name="fd_comment[model_field]"][type="hidden"]')->
    checkElement('div#comment_form input[name="fd_comment[profile_id]"][type="hidden"]')->

    checkElement('div#comments_list h3:contains("pippo")')->
    checkElement('div#comments_list p:contains("pippo pippo poivnonjoifwe ijewjpfjpw ....")')->
    checkElement('div#comments_list div:contains("by prog (puser) prog")')->
    checkElement('div#comments_list div:contains("by Mario (user) Wage")')->

    checkElement('div#comments_list div.navigation a[href~="idProject/2/idMessage/show/1?page=2"]', 3)->
    checkElement('div#comments_list div.navigation span:contains("1")')->

  end()
;
