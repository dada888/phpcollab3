<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new repositoryTestFunctional(new sfBrowser());
$browser->readGitFakeRepository();

$browser->
  post('/en/idRepository/showall', array('rep'=>'git'))->
 
  with('request')->begin()->
    isParameter('module', 'idRepository')->
    isParameter('action', 'showall')->
  end()->
 
  with('response')->begin()->
    isStatusCode(200)->
    
    checkElement('.block .content .table td a[href*="/index.php/en/idRepository/showdetails/revisionid/ee05abb"]')->
    checkElement('.block .content .table td a[href*="/index.php/en/idRepository/showdetails/revisionid/a3ed353"]')->
  end()
;
