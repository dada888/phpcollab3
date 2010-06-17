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
    
    checkElement('#navigation ul li a[href*="/idDashboard"]', 'Dashboard')->
    checkElement('#navigation ul li a[href*="/idProject"]', 'Projects')->
    checkElement('#navigation ul li a[href*="Logtime"]', 'Time')->
    checkElement('#navigation ul li a:contains("Calendar")', 0)->
    checkElement('#navigation ul li a[href*="/idUsers"]', 'Users')->
    checkElement('#navigation ul li a:contains("Messages")', 0)->

    checkElement('#navigationRight a:contains("Quick Add")', 0)->

    checkElement('#utility a[href*="/logout"]', 'Logout')->
    checkElement('#utility a[href="#"]', 'Settings')->
    checkElement('#utility a[class="help"][href="#"]', 'Help')->

  end();