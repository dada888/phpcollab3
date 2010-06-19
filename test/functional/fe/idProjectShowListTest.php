<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();

$browser->

get('/en/idProject')->
click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'idProject')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#content .span-full .title', '/Projects/')->
    checkElement('#content .span-full .title a[href*="en/idProject/new"]', '/Add/')->

    checkElement('#project .odd h3 a[href*="idProject/show"]', '/Il mio quarto progetto/', array('position' => 0))->
    checkElement('#project .even h3 a[href*="idProject/show"]', '/Il mio primo progetto/', array('position' => 0))->
    checkElement('#project .even h3 a[href*="idProject/show"]', '/Il mio secondo progetto/', array('position' => 1))->
    checkElement('#project .odd h3 a[href*="idProject/show"]', '/Il mio terzo progetto/', array('position' => 1))->
    checkElement('#project .odd h3 a[href*="idProject/show"]', '/Gant chart project/', array('position' => 2))->

    checkElement('#project .even .span-one-quarter', '/Status/')->
    checkElement('#project .even .span-one-quarter', '/43.48%/')->
    checkElement('#project .even .span-one-quarter', '/Completed/')->

    checkElement('#project .even .span-one-quarter', '/Assigned to me/', array('position' => 1))->
    checkElement('#project .even .span-one-quarter', '/Total/', array('position' => 2))->
    checkElement('#project .even .span-one-quarter', '/13/', array('position' => 2))->
    checkElement('#project .even .span-one-quarter', '/Open/', array('position' => 2))->
    checkElement('#project .even .span-one-quarter', '/10/', array('position' => 2))->
    checkElement('#project .even .span-one-quarter', '/Closed/', array('position' => 2))->

    checkElement('#sidebar')->
    checkElement('#sidebar form')->
    checkElement('#sidebar select', 15)->
    checkElement('#sidebar input')->
  end();