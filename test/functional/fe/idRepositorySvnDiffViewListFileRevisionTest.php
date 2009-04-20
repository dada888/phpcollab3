<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new repositoryTestFunctional(new sfBrowser());
$browser->readSvnFakeRepository();

$browser->
  post('/en/idRepository/show')->
  click('154')->
  click('diff')->

  with('request')->begin()->
    isParameter('module', 'idRepository')->
    isParameter('action', 'showdifflist')->
    isParameter('path','newProject%2Ffile112.php')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#container #header h1', 'Revision List')->
    checkElement('#block-tables div.content h2.title', 'Revision list for newProject/file112.php')->
    checkElement('#block-tables div.content form.form', 1)->
    checkElement('#block-tables div.content form[action="/index.php/en/idRepository/showdiff"]', 1)->
    checkElement('#block-tables div.content form.form table.table th.first','Revision Number')->
    checkElement('#block-tables div.content form.form table.table th:contains("Author")', 1)->
    checkElement('#block-tables div.content form.form table.table th:contains("Date")', 1)->
    checkElement('#block-tables div.content form.form table.table th:contains("Message")', 1)->

    checkElement('#block-tables div.content form.form table.table tr.odd', 4)->

    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("154")')->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("153")')->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("152")')->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("114")')->
    
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("2009-03-22")', 4)->

    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("modified (removed 14) file112.php")', 1)->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("modified (removed 13) file112.php")', 1)->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("modified (removed 12) file112.php")', 1)->
    checkElement('#block-tables div.content form.form table.table tr.odd td:contains("touched file112.php")', 1)->

    //radio button
    checkElement('#block-tables div.content form.form table.table tr.odd td input[name="revision_left"]', 3)->
    checkElement('#block-tables div.content form.form table.table tr.odd td input[name="revision_right"]', 3)->

    //submit button
    checkElement('#block-tables div.content form.form div.actions-bar div.actions input.button')->
    end();

    $browser->
    //testare il fatto che una volta settate le revision ci restituisce gli errori desiderati
    //array('rep'=>'TestSVN'), array('method'=>'post')
    click('Show Diff', array('revision_left' => '', 'revision_right' => ''), array('method' => 'post'))->
    responseContains('You must select different revision to visualize their differences')->
    responseContains('First diff revison required')->
    responseContains('Second diff revison required')->


    click('Show Diff', array('revision_left' => '50000', 'revision_right' => '5000001'), array('method' => 'post'))->
    responseContains('You should Select 2 values of 2 different revision')->

    click('Show Diff', array('revision_left' => '7', 'revision_right' => ''), array('method' => 'post'))->
    responseContains('Second diff revison required')->

    click('Show Diff', array('revision_left' => '', 'revision_right' => '6'), array('method' => 'post'))->
    responseContains('First diff revison required')

;