<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new idDoctrineTestFunctional(new sfBrowser());
$browser->initializeDatabase();


$browser->

  get('/')->
  click('Login', array('signin' => array('username' => 'puser', 'password' => 'puser')))->
  followRedirect()->

  click('Il mio terzo progetto')->

  click('Issues')->

  click('#1')->

  with('request')->begin()->
    isParameter('module', 'idIssue')->
    isParameter('action', 'show')->
    isParameter('issue_id', '1')->
  end()->

  with('response')->begin()->
    isStatusCode('200')->

    checkElement('div.secondary-navigation li a[href="/index.php/en/idProject/show/3"]', 'Go back to the project dashboard')->

    checkElement('table.table tr th:contains("Id")')->
    checkElement('table.table tr th:contains("Title")')->
    checkElement('table.table tr th:contains("Description")')->
    checkElement('table.table tr th:contains("Milestone")')->
    checkElement('table.table tr th:contains("Starting date")')->
    checkElement('table.table tr th:contains("Ending date")')->
    checkElement('table.table tr th:contains("Status")')->
    checkElement('table.table tr th:contains("Assigned to")')->
    checkElement('table.table tr th:contains("Priority")')->
    checkElement('table.table tr th:contains("Milestone")')->
    checkElement('table.table tr th:contains("Tracker")')->
    checkElement('table.table tr th:contains("Actions")')->

    checkElement('table.table tr td:contains("#1")')->

    checkElement('table.table tr td a[href="/index.php/en/idProject/3/idIssue/edit/1"]', 'Edit')->
    checkElement('table.table tr td a[href="/index.php/en/idProject/3/idIssue/delete/1"]', 'Delete')->

//    checkElement('div#comment-form form.form input[id="comment_id"][type="hidden"]')->
//    checkElement('div#comment-form form.form input[id="comment_issue_id"][type="hidden"][value="1"]')->
//    checkElement('div#comment-form form.form input[id="comment_profile_id"][type="hidden"][value="3"]')->
//    checkElement('div#comment-form form.form input[id="comment_created_at"][type="hidden"]')->
//    checkElement('div#comment-form form.form div.left div.group textarea[id="comment_body"]')->

    checkElement('div#comment_form form.form input[name="fd_comment[title]"]')->
    checkElement('div#comment_form form.form textarea[name="fd_comment[body]"]')->
    checkElement('div#comment_form form.form input[value="Leave a comment"]')->

    checkElement('div#comments_list h3:contains("pippo2")')->
    checkElement('div#comments_list p:contains("pippo2")')->

    checkElement('div#related-issue table.table tr td a[href="/index.php/en/idProject/3/idIssue/show/2"]', '#2')->
    checkElement('div#related-issue table.table tr td a[href="/index.php/en/idProject/3/idIssue/show/3"]', '#3')->
    checkElement('div#related-issue table.table tr td a[href="/index.php/en/idProject/3/idIssue/show/4"]', '#4')->
    checkElement('div#related-issue table.table tr td a[href="/index.php/en/idProject/3/idIssue/show/6"]', false)->

    checkElement('tr td span', '1')->
    checkElement('tr td a[href="/index.php/en/idProject/3/idIssue/show/1?page=2"]', '2')->

  end()->

  click('Issues list')->

  click('#5')->

   with('response')->begin()->
    isStatusCode('200')->

    checkElement('div#related-issue table.table tr td a[href="/index.php/en/idProject/3/idIssue/show/1"]', '#1')->
    
  end()->

  click('Issues list')->

  click('#2')->

  with('response')->begin()->
    isStatusCode('200')->

    checkElement('#issue-table tr td ul li:contains("prog (puser) prog")')->
    checkElement('#issue-table tr td ul li:contains("Mario (user) Wage ")')->

  end()

;
