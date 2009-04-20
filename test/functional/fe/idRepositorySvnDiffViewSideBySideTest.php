<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new repositoryTestFunctional(new sfBrowser());
$browser->readSvnFakeRepository();

$browser->
  post('/en/idRepository/show')->
  click('154')->
  click('diff')->

  click('Show Diff', array('revision_left' => '154', 'revision_right' => '152'), array('method' => 'post'))->

  with('request')->begin()->
    isParameter('module', 'idRepository')->
    isParameter('action', 'showdiff')->
  end()->


  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#container #header h1', 'View Diff')->
    checkElement('#block-tables div.content h2.title', 'From revision 152 to revision 154')->
    checkElement('#block-tables div.content table.difftable tr th:contains("newProject/file112.php")')->

    checkElement('#block-tables div.content table.difftable tr td.break', 4)->
    
    checkElement('#block-tables div.content table.difftable tr td.red','44', array('position'=>0))->
    checkElement('#block-tables div.content table.difftable tr td.red','file13.php', array('position'=>1))->
    checkElement('#block-tables div.content table.difftable tr td.red','55', array('position'=>2))->
    checkElement('#block-tables div.content table.difftable tr td.red','file14.php', array('position'=>3))->
    
  end();
