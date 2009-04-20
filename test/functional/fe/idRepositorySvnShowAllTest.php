<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new repositoryTestFunctional(new sfBrowser());
$browser->readSvnFakeRepository();

$browser->
  post('/en/idRepository/showall')->
 
  with('request')->begin()->
    isParameter('module', 'idRepository')->
    isParameter('action', 'showall')->
  end()->
 
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('.block .content .table td a[href="/index.php/en/idRepository/showdetails/revisionid/154"]',1)->
    checkElement('.block .content .table td a[href="/index.php/en/idRepository/showdetails/revisionid/1"]',1)->

  end()
;