<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());

$browser->initializeDatabase();

$browser->
  get('/')->
  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')), array('position' => 1, 'method' => 'post'))->
  followRedirect()->
  
  with('response')->begin()->
    isStatusCode(200)->
    
    checkElement('.navigation ul li a[href*="/idDashboard"]', 'Dashboard')->
    checkElement('.navigation ul li a[href*="/idProject"]', 'Projects')->
    checkElement('.navigation ul li a[href*="Logtime"]', 'Time')->
    checkElement('.navigation ul li a[href="calendar.html"]', 'Calendar')->
    checkElement('.navigation ul li a[href*="/idUsers"]', 'Users')->
    checkElement('.navigation ul li a[href="messages.html"]', '/Messages/')->

    checkElement('.navigationRight a[id="addIcon"][href="#"]', '/Quick Add/')->

    checkElement('.utility-nav a[href*="/logout"]', 'Logout')->
    checkElement('.utility-nav a[href="#"]', 'Settings')->
    checkElement('.utility-nav a[class="utilHelp"][href="#"]', 'Help')->

  end();