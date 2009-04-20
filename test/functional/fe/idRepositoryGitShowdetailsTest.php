<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new repositoryTestFunctional(new sfBrowser());
$browser->readGitFakeRepository();

$browser->
  post('/en/idRepository/show', array('rep'=>'git'))->
  click('ee05abb', array('rep'=>'git'), array('method'=>'post'))->

  with('request')->begin()->
    isParameter('module', 'idRepository')->
    isParameter('action', 'showdetails')->
    isParameter('revisionid','ee05abb')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#container #header h1', 'Revision Details')->
    checkElement('#block-text div.content h2.title', 'Details from revision ee05abb')->
    checkElement('#block-text div.content div.inner p.first', '/Revision ee05abb has been committed on 2009-03-21 by */')->
    checkElement('#block-text div.content div.inner p span.hightlight', 'Message : modified (removed 14) file112.php')->
    
    checkElement('#block-lists div.content h2.title', 'Modified Files')->
    checkElement('#block-lists div.content div.inner ul.list li div.left', 'M')->
    checkElement('#block-lists div.content div.inner ul.list li div.item', 'file112.php [diff]')->
    checkElement('#block-lists div.content div.inner ul.list li div.item a[href="/index.php/en/idRepository/showdifflist/path/file112.php"]', 'diff')->

  end()
;
