<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new repositoryTestFunctional(new sfBrowser());
$browser->readGitFakeRepository();

$browser->
  post('/en/idRepository/show', array('rep'=>'git'))->
  click('ee05abb', array('rep'=>'git'), array('method'=>'post'))->
  click('diff', array('rep'=>'git'), array('method'=>'post'))->

  with('request')->begin()->
    isParameter('module', 'idRepository')->
    isParameter('action', 'showdifflist')->
    isParameter('path','file112.php')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#container #header h1', 'Revision List')->
    checkElement('#block-tables div.content h2.title', 'Revision list for file112.php')->
    checkElement('#block-tables div.content form.form', 1)->
    checkElement('#block-tables div.content form[action="/index.php/en/idRepository/showdiff"]', 1)->
    checkElement('#block-tables div.content form.form table.table th.first','Revision Number')->
    checkElement('#block-tables div.content form.form table.table th:contains("Author")',1)->
    checkElement('#block-tables div.content form.form table.table th:contains("Date")',1)->
    checkElement('#block-tables div.content form.form table.table th:contains("Message")',1)->

    checkElement('#block-tables div.content form.form table.table tr.odd', 54)->

    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("b025f34")')->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("7a17aab")')->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("9102830")')->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("ef1f430")')->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("a7d3567")')->

    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("2009-03-21")', 54)->

    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("modified (501) file112.php")', 1)->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("modified (502) file112.php")', 1)->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("modified (503) file112.php")', 1)->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("modified (504) file112.php")', 1)->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("modified (505) file112.php")', 1)->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("touched file112.php")', 1)->

    //radio button
    checkElement('#block-tables div.content form.form table.table tr.odd td input[name="revision_left"]', 53)->
    checkElement('#block-tables div.content form.form table.table tr.odd td input[name="revision_right"]', 53)->

    //submit button
    checkElement('#block-tables div.content form.form div.actions-bar div.actions input.button')->
    end();

    $browser->
    click('Show Diff', array('revision_left' => '', 'revision_right' => '','rep'=>'git'), array('method' => 'post'))->
    responseContains('You must select different revision to visualize their differences')->
    responseContains('First diff revison required')->
    responseContains('Second diff revison required')->


    click('Show Diff', array('revision_left' => '1234567', 'revision_right' => '2345678','rep'=>'git'), array('method' => 'post'))->
    responseContains('You should Select 2 values of 2 different revision')->

    click('Show Diff', array('revision_left' => 'ce1c648', 'revision_right' => '','rep'=>'git'), array('method' => 'post'))->
    responseContains('Second diff revison required')->

    click('Show Diff', array('revision_left' => '', 'revision_right' => 'ea1d685','rep'=>'git'), array('method' => 'post'))->
    responseContains('First diff revison required')
;