<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();



  $browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Users')->
  click('Username')->
  with('response')->begin()->
    checkElement('div#block-tables .table tr th a:contains("Username")')->
    checkElement('div#block-tables .table tr th img[title="asc"]')->
    
    checkElement('#block-tables .table tr.odd td', '/admin/', array('position' => 1))->
    checkElement('#block-tables .table tr.even td', '/customer/', array('position' => 1))->
    checkElement('#block-tables .table tr.odd td', '/nopuser/', array('position' => 8))->
    checkElement('#block-tables .table tr.even td', '/pmanager/', array('position' => 8))->
    checkElement('#block-tables .table tr.odd td', '/puser/', array('position' => 15))->
  end()->

  click('Next')->
  with('response')->begin()->
    checkElement('div#block-tables .table tr th a:contains("Username")')->
    checkElement('div#block-tables .table tr th img[title="asc"]')->

    checkElement('#block-tables .table tr td', '/sesto/', array('position' => 1))->
  end()->

  click('First')->
  click('Username')->
  with('response')->begin()->
    checkElement('div#block-tables .table tr th a:contains("Username")')->
    checkElement('div#block-tables .table tr th img[title="desc"]')->

    checkElement('#block-tables .table tr.odd td', '/userp2/', array('position' => 1))->
    checkElement('#block-tables .table tr.even td', '/user/', array('position' => 1))->
    checkElement('#block-tables .table tr.odd td', '/sesto/', array('position' => 8))->
    checkElement('#block-tables .table tr.even td', '/puser/', array('position' => 8))->
    checkElement('#block-tables .table tr.odd td', '/pmanager/', array('position' => 15))->
  end()->

  click('First name')->
  with('response')->begin()->
    checkElement('div#block-tables .table tr th a:contains("First name")')->
    checkElement('div#block-tables .table tr th img[title="asc"]')->

    checkElement('#block-tables .table tr.odd td', '/Amministro/', array('position' => 9))->
    checkElement('#block-tables .table tr.even td', '/Mario/', array('position' => 9))->
    checkElement('#block-tables .table tr.odd td', '/customer/', array('position' => 16))->
  end()->

  click('First name')->
  with('response')->begin()->
    checkElement('div#block-tables .table tr th a:contains("First name")')->
    checkElement('div#block-tables .table tr th img[title="desc"]')->

    checkElement('#block-tables .table tr.odd td', '/project2user/', array('position' => 2))->
    checkElement('#block-tables .table tr.even td', '/prog/', array('position' => 2))->
    checkElement('#block-tables .table tr.odd td', '/paul/', array('position' => 9))->
    checkElement('#block-tables .table tr.even td', '/customer/', array('position' => 9))->
  end()->

  click('Last name')->
  with('response')->begin()->
    checkElement('div#block-tables .table tr th a:contains("Last name")')->
    checkElement('div#block-tables .table tr th img[title="asc"]')->

    checkElement('#block-tables .table tr.odd td', '/Amministro/', array('position' => 10))->
    checkElement('#block-tables .table tr.even td', '/Wage/', array('position' => 10))->
    checkElement('#block-tables .table tr.odd td', '/customer/', array('position' => 17))->
  end()->

  click('Last name')->
  with('response')->begin()->
    checkElement('div#block-tables .table tr th a:contains("Last name")')->
    checkElement('div#block-tables .table tr th img[title="desc"]')->

    checkElement('#block-tables .table tr.odd td', '/project2user/', array('position' => 3))->
    checkElement('#block-tables .table tr.even td', '/prog/', array('position' => 3))->
    checkElement('#block-tables .table tr.odd td', '/mange/', array('position' => 10))->
    checkElement('#block-tables .table tr.even td', '/customer/', array('position' => 10))->
  end()->

  click('Email')->
  with('response')->begin()->
    checkElement('div#block-tables .table tr th a:contains("Email")')->
    checkElement('div#block-tables .table tr th img[title="asc"]')->

    checkElement('#block-tables .table tr.odd td', 'amministro@example.com', array('position' => 4))->
    checkElement('#block-tables .table tr.even td', '/customer@example.com/', array('position' => 4))->
    checkElement('#block-tables .table tr.odd td', '/mario@example.com/', array('position' => 11))->
    checkElement('#block-tables .table tr.even td', '/pmanager@example.com/', array('position' => 11))->
    checkElement('#block-tables .table tr.odd td', '/project2user@example.com/', array('position' => 18))->
  end()->

  click('Email')->
  with('response')->begin()->
    checkElement('div#block-tables .table tr th a:contains("Last name")')->
    checkElement('div#block-tables .table tr th img[title="desc"]')->

    checkElement('#block-tables .table tr.odd td', '/sesto@example.com/', array('position' => 4))->
    checkElement('#block-tables .table tr.even td', '/quarto@example.com/', array('position' => 4))->
    checkElement('#block-tables .table tr.odd td', '/puser@example.com/', array('position' => 11))->
    checkElement('#block-tables .table tr.even td', '/project2user@example.com/', array('position' => 11))->
    checkElement('#block-tables .table tr.odd td', '/pmanager@example.com/', array('position' => 18))->
  end()->

  click('Created at')->
  with('response')->begin()->
    checkElement('div#block-tables .table tr th a:contains("Email")')->
    checkElement('div#block-tables .table tr th img[title="asc"]')->

    checkElement('#block-tables .table tr.odd td', '/amministro@example.com/', array('position' => 4))->
    checkElement('#block-tables .table tr.even td', '/mario@example.com/', array('position' => 4))->
    checkElement('#block-tables .table tr.odd td', '/puser@example.com/', array('position' => 11))->
    checkElement('#block-tables .table tr.even td', '/quarto@example.com/', array('position' => 11))->
    checkElement('#block-tables .table tr.odd td', '/project2user@example.com/', array('position' => 18))->
  end()->

  click('Created at')->
  with('response')->begin()->
    checkElement('div#block-tables .table tr th a:contains("Last name")')->
    checkElement('div#block-tables .table tr th img[title="desc"]')->

    checkElement('#block-tables .table tr.odd td', '/customer@example.com/', array('position' => 4))->
    checkElement('#block-tables .table tr.even td', '/mario@example.com/', array('position' => 4))->
    checkElement('#block-tables .table tr.odd td', '/puser@example.com/', array('position' => 11))->
    checkElement('#block-tables .table tr.even td', '/quarto@example.com/', array('position' => 11))->
    checkElement('#block-tables .table tr.odd td', '/project2user@example.com/', array('position' => 18))->
  end()

;