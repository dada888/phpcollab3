<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new repositoryTestFunctional(new sfBrowser());
$browser->readSvnFakeRepository();

$browser->
  post('/en/idRepository/show')->
  click('154')->

  with('request')->begin()->
    isParameter('module', 'idRepository')->
    isParameter('action', 'showdetails')->
    isParameter('revisionid','154')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#container #header h1', 'Revision Details')->
    checkElement('#block-text div.content h2.title', 'Details from revision 154')->
    checkElement('#block-text div.content div.inner p.first', '/Revision 154 has been committed on 2009-03-22 by */')->
    checkElement('#block-text div.content div.inner p span.hightlight', 'Message : modified (removed 14) file112.php')->
    
    checkElement('#block-lists div.content h2.title', 'Modified Files')->
    checkElement('#block-lists div.content div.inner ul.list li div.left', 'M')->
    checkElement('#block-lists div.content div.inner ul.list li div.item', 'newProject/file112.php [diff]')->
    checkElement('#block-lists div.content div.inner ul.list li div.item a[href="/index.php/en/idRepository/showdifflist/path/newProject%252Ffile112.php"]', 'diff')->

  end()
;