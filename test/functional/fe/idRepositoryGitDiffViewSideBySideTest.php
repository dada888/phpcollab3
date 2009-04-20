<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new repositoryTestFunctional(new sfBrowser());
$browser->readGitFakeRepository();

$browser->
  post('/en/idRepository/show', array('rep'=>'git'))->
  click('ee05abb', array('rep'=>'git'), array('method'=>'post'))->
  click('diff', array('rep'=>'git'), array('method'=>'post'))->

  click('Show Diff', array('revision_left' => 'ee05abb', 'revision_right' => '7d99204', 'rep'=>'git'), array('method' => 'post'))->

  with('request')->begin()->
    isParameter('module', 'idRepository')->
    isParameter('action', 'showdiff')->
  end()->


  with('response')->begin()->
    isStatusCode(200)->
    
    checkElement('#container #header h1', 'View Diff')->
    checkElement('#block-tables div.content h2.title', 'From revision 7d99204 to revision ee05abb')->
    checkElement('#block-tables div.content table.difftable tr th:contains("file112.php")')->

    checkElement('#block-tables div.content table.difftable tr td.red','84', array('position'=>0))->
    checkElement('#block-tables div.content table.difftable tr td.red','file12.php', array('position'=>1))->
    checkElement('#block-tables div.content table.difftable tr td.red','95', array('position'=>2))->
    checkElement('#block-tables div.content table.difftable tr td.red','file13.php', array('position'=>3))->
    checkElement('#block-tables div.content table.difftable tr td.red','106', array('position'=>4))->
    checkElement('#block-tables div.content table.difftable tr td.red','file14.php', array('position'=>5))->

    checkElement('#block-tables div.content table.difftable tr td.break', 8)->
    
  end();

//$browser->removeSvnFakeRepository();
