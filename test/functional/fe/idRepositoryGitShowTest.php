<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new repositoryTestFunctional(new sfBrowser());
$browser->readGitFakeRepository();

$browser->
  post('/en/idRepository/show', array('rep'=>'git'))->
 
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
    
    checkElement('.block .content .table td a[href*="/index.php/en/idRepository/showdetails/revisionid/"]',10)->
    
    checkElement('td:contains("2009-03-21")', 10)->

    checkElement('td:contains("modified (removed 14) file112.php")', 1)->
    checkElement('td:contains("modified (removed 13) file112.php")', 1)->
    checkElement('td:contains("modified (removed 13) file112.php")', 1)->
    checkElement('td:contains("modified (550) file112.php")', 1)->
    checkElement('td:contains("modified (549) file112.php")', 1)->
    checkElement('td:contains("modified (548) file112.php")', 1)->
    checkElement('td:contains("modified (547) file112.php")', 1)->
    checkElement('td:contains("modified (546) file112.php")', 1)->
    checkElement('td:contains("modified (545) file112.php")', 1)->
    checkElement('td:contains("modified (544) file112.php")', 1)->
    
    checkElement('tr',11)->
  end()
;
