<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new repositoryTestFunctional(new sfBrowser());
$browser->readSvnFakeRepository();

$browser->
  post('/en/idRepository/show')->
 
  with('request')->begin()->
    isParameter('module', 'idRepository')->
    isParameter('action', 'show')->
  end()->
 
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#container #header h1', 'Repository Revisions')->
    checkElement('.table th:contains("Log Entry")', false)->
    checkElement('.table th:contains("Revision Number")', 1)->
    checkElement('.table th:contains("Author")', 1)->
    checkElement('.table th:contains("Date")', 1)->
    checkElement('.table th:contains("Message")', 1)->

    checkElement('.block .content .table td a[href="/index.php/en/idRepository/showdetails/revisionid/154"]',1)->
    checkElement('.block .content .table td a[href="/index.php/en/idRepository/showdetails/revisionid/153"]',1)->
    checkElement('.block .content .table td a[href="/index.php/en/idRepository/showdetails/revisionid/152"]',1)->
    checkElement('.block .content .table td a[href="/index.php/en/idRepository/showdetails/revisionid/151"]',1)->
    checkElement('.block .content .table td a[href="/index.php/en/idRepository/showdetails/revisionid/150"]',1)->
    checkElement('.block .content .table td a[href="/index.php/en/idRepository/showdetails/revisionid/149"]',1)->
    checkElement('.block .content .table td a[href="/index.php/en/idRepository/showdetails/revisionid/148"]',1)->
    checkElement('.block .content .table td a[href="/index.php/en/idRepository/showdetails/revisionid/147"]',1)->
    checkElement('.block .content .table td a[href="/index.php/en/idRepository/showdetails/revisionid/146"]',1)->
    checkElement('.block .content .table td a[href="/index.php/en/idRepository/showdetails/revisionid/145"]',1)->
    
    checkElement('td:contains("2009-03-22")', 10)->

    checkElement('td:contains("modified (removed 14) file112.php")', 1)->
    checkElement('td:contains("modified (removed 13) file112.php")', 1)->
    checkElement('td:contains("modified (removed 12) file112.php")', 1)->
    checkElement('td:contains("touched file149.php")', 1)->
    checkElement('td:contains("touched file148.php")', 1)->
    checkElement('td:contains("touched file147.php")', 1)->
    checkElement('td:contains("touched file146.php")', 1)->
    checkElement('td:contains("touched file145.php")', 1)->
    checkElement('td:contains("touched file144.php")', 1)->
    checkElement('td:contains("touched file143.php")', 1)->
    
    checkElement('tr',11)->

  end()
;