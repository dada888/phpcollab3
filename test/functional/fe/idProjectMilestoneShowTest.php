<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->

  click('Projects')->

  click('Il mio terzo progetto')->
  click('Milestones')->

  click('third iteration')->

  with('response')->begin()->
    checkElement('.title:contains("third iteration")')->
    checkElement('.description:contains("third iteration for project 3")')->

    checkElement('a[href="/index.php/en/idProject/3/idMilestone/edit/3"]', 'Edit')->
    checkElement('a[href="/index.php/en/idProject/3/idMilestone/detele/3"]', 'Delete')->

    checkElement('ul li:contains("new issue 51")')->
    checkElement('ul li:contains("new issue 52")')->
    checkElement('ul li:contains("new issue 53")')->
    checkElement('ul li:contains("new issue 54")')->
    checkElement('ul li:contains("new issue 55")')->
    checkElement('ul li:contains("new issue 61")', false)->

    checkElement('ul.time li', 80)->

    checkElement('.pagenation ul li', 4)->
    checkElement('.pagenation ul li a[href*="en/idProject/3/idMilestone/show/3?page=1"]', '1')->
    checkElement('.pagenation ul li a[href*="en/idProject/3/idMilestone/show/3?page=2"]', '2')->
    checkElement('.pagenation ul li a img[title="Next"]')->
    checkElement('.pagenation ul li a:contains("Last")')->
        
    checkElement('.description ul li:contains("Estimated time")')->
    checkElement('.description ul li:contains("0.0")')->
    checkElement('.description ul li:contains("Issues estimated time")')->
    checkElement('.description ul li:contains("95.0")')->

  end()->
  
  click('Dashboard')->
  click('Logout')->

  get('/')->

  click('Login', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  followRedirect()->

  click('Projects')->
  click('Il mio primo progetto')->
  click('Milestones')->
  click('first iteration')->

  with('response')->begin()->
    checkElement('.description ul li:contains("Issues estimated time")')->
    checkElement('.description ul li:contains("101.0")')->
  end()
;