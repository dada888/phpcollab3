<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();



  $browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Settings')->
  click('Username')->
  with('response')->begin()->
    checkElement('ul.action li.icon-group ul li.span-5', '/admin/', array('position' => 0))->
    checkElement('ul.action li.icon-group ul li.span-5', '/customer/', array('position' => 3))->
    checkElement('ul.action li.icon-group ul li.span-5', '/nopuser/', array('position' => 6))->
    checkElement('ul.action li.icon-group ul li.span-5', '/pmanager/', array('position' => 9))->
    checkElement('ul.action li.icon-group ul li.span-5', '/puser/', array('position' => 12))->
  end()->

  click('Next')->
  with('response')->begin()->
    checkElement('ul.action li.icon-group ul li.span-5', '/sesto/', array('position' => 0))->
  end()->

  click('First')->
  click('Username')->
  with('response')->begin()->
    checkElement('ul.action li.icon-group ul li.span-5', '/userp2/', array('position' => 0))->
    checkElement('ul.action li.icon-group ul li.span-5', '/user/', array('position' => 3))->
    checkElement('ul.action li.icon-group ul li.span-5', '/sesto/', array('position' => 6))->
    checkElement('ul.action li.icon-group ul li.span-5', '/puser/', array('position' => 9))->
    checkElement('ul.action li.icon-group ul li.span-5', '/pmanager/', array('position' => 12))->
  end()->

  click('First Name')->
  with('response')->begin()->
    checkElement('ul.action li.icon-group ul li.span-5', '/Amministro/', array('position' => 7))->
    checkElement('ul.action li.icon-group ul li.span-5', '/Mario/', array('position' => 10))->
    checkElement('ul.action li.icon-group ul li.span-5', '/customer/', array('position' => 13))->
  end()->

  click('Last Name')->
  with('response')->begin()->
    checkElement('ul.action li.icon-group ul li.span-5', '/Amministro/', array('position' => 7))->
    checkElement('ul.action li.icon-group ul li.span-5', '/Mario/', array('position' => 10))->
    checkElement('ul.action li.icon-group ul li.span-5', '/customer/', array('position' => 13))->
  end();