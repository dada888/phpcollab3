<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
initializeDatabase();

$configuration = ProjectConfiguration::getApplicationConfiguration( 'fe', 'unittest', true);
new sfDatabaseManager($configuration);
Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures/fixtures.yml');

$t = new lime_test(52, new lime_output_color());

$t->ok(Doctrine::getTable('Project')->getProjectRelatedMilestonesAndIssues(1) instanceof Project, 'getProjectRelatedMilestonesAndIssues(1) returns a propject object');
$t->is(Doctrine::getTable('Project')->getProjectRelatedMilestonesAndIssues(1213782), null, 'getProjectRelatedMilestonesAndIssues(1213782) returns null if the project is not found');

$t->ok(Doctrine::getTable('Project')->getProjectMilestonesAndUsers(1) instanceof Project, 'getProjectMilestonesAndUsers(1) returns a propject object');
$t->is(Doctrine::getTable('Project')->getProjectMilestonesAndUsers(1213782), null, 'getProjectMilestonesAndUsers(1213782) returns null if the project is not found');

$projects = Doctrine::getTable('Project')->getQueryToRetrieveProjectWhereUserHaveAssignedIssues(2)->execute();

$t->is(count($projects), 2, 'getQueryToRetrieveProjectWhereUserHaveAssignTickets(user) returns one project');
$t->is($projects['0']['id'], 1, 'getQueryToRetrieveProjectWhereUserHaveAssignTickets(user) returns the right project');

$t->is(Doctrine::getTable('Project')->projectExists(1), true, 'projectExists() return true for project 1');
$t->is(Doctrine::getTable('Project')->projectExists(5), true, 'projectExists() return true for project 5');
$t->is(Doctrine::getTable('Project')->projectExists(11111111), false, 'projectExists() return true for project 11111111');

$project_is = Doctrine::getTable('Project')->getRecentPrjectsIdAndName();

$t->is(count($project_is), 3, '->getRecentPrjectsId() retrieves 3 projects ids');
$t->is($project_is[0]['id'], 5, '->getRecentPrjectsId() the right id');
$t->is($project_is[0]['name'], 'Gant chart project', '->getRecentPrjectsId() the right id');
$t->is($project_is[1]['id'], 2, '->getRecentPrjectsId() the right id');
$t->is($project_is[1]['name'], 'Il mio secondo progetto', '->getRecentPrjectsId() the right id');
$t->is($project_is[2]['id'], 1, '->getRecentPrjectsId() the right id');
$t->is($project_is[2]['name'], 'Il mio primo progetto', '->getRecentPrjectsId() the right id');

$projects_reports = Doctrine::getTable('Project')->getReportsForRecentProjects();

$t->is(count($projects_reports), 3, '->getReportsForRecentProjects() retrieves 3 projects ids');
$t->is($projects_reports[1]['project_name'], 'Il mio primo progetto', '->getReportsForRecentProjects() the right project_name');
$t->is($projects_reports[1]['completion_percentage'], '43.48', '->getReportsForRecentProjects() the right completion_percentage');
$t->is($projects_reports[1]['assigned_percentage'], '4.35', '->getReportsForRecentProjects() the right remaining_issues');
$t->is($projects_reports[1]['closed_issues'], '10', '->getReportsForRecentProjects() the right closed_issues');
$t->is($projects_reports[1]['remaining_issues'], '13', '->getReportsForRecentProjects() the right remaining_issues');
$t->is($projects_reports[1]['on_time'], Project::ONTIME, '->getReportsForRecentProjects() the right on_time');

$t->is($projects_reports[2]['messages'], 2, '->getReportsForRecentProjects() the right messages');

/** TODO !! $t->is($projects_reports[0]['commits'], 3, '->getRecentPrjectsId() the right id'); **/


$has_exceeded_estimated_hours = Doctrine::getTable('Project')->hasExceededEstimatedHours(5);
$t->ok(!$has_exceeded_estimated_hours, '->hasExceededEstimatedHours() return false');

$has_exceeded_estimated_hours = Doctrine::getTable('Project')->hasExceededEstimatedHours(3);
$t->ok(!$has_exceeded_estimated_hours, '->hasExceededEstimatedHours() return false');

$has_exceeded_estimated_hours = Doctrine::getTable('Project')->hasExceededEstimatedHours(2);
$t->ok(!$has_exceeded_estimated_hours, '->hasExceededEstimatedHours() return false');

//aggiungere l'esitmated time al 4° progetto e un ticket con log time più alto;
$issue = new Issue();
$issue->title = "test issue";
$issue->project_id = 2;
$issue->estimated_time = 10;
$issue->save();

$log_time = new LogTime();
$log_time->issue_id = $issue->id;
$log_time->log_time = 15;
$log_time->user_id = 1;
$log_time->save();

$has_exceeded_estimated_hours = Doctrine::getTable('Project')->hasExceededEstimatedHours(2);
$t->ok($has_exceeded_estimated_hours, '->hasExceededEstimatedHours() returns true');

$is_project_on_time = Doctrine::getTable('Project')->isProjectOnTime(2);
$t->is($is_project_on_time, Project::EXCEEDING_ESTIMATION,'isOnTime() returns Project::EXCEEDING_ESTIMATION');

$is_project_on_time = Doctrine::getTable('Project')->isProjectOnTime(1);
$t->is($is_project_on_time, Project::ONTIME,'isOnTime() returns Project::ONTIME');

$is_project_on_time = Doctrine::getTable('Project')->isProjectOnTime(4);
$t->is($is_project_on_time, Project::LATE,'isOnTime() returns Project::LATE');


$report = Doctrine::getTable('Project')->getReportOnProject(2);

$t->is($report['completion_percentage'], '0', '->getReportsForRecentProjects() the right completion_percentage');
$t->is($report['assigned_percentage'], '0', '->getReportsForRecentProjects() the right remaining_issues');
$t->is($report['closed_issues'], '0', '->getReportsForRecentProjects() the right closed_issues');
$t->is($report['remaining_issues'], '7', '->getReportsForRecentProjects() the right remaining_issues');
$t->is($report['messages'], 2, '->getReportsForRecentProjects() the right messages');

/*reports for projects with effort charts*/
$t->info('Start with tests on report with charts');

$data = Doctrine::getTable('Project')->getEffortDataForChart(1);
$t->is(count($data), 14, 'getEffortDataForChart() retrieves the right number of days');
$t->is($data[date('Y-m-d')], '1.2', 'getEffortDataForChart() retrieves the right log times');
$t->is($data[date('Y-m-d', strtotime('-1 day'))], '81.3', 'getEffortDataForChart() retrieves the right log times');
$t->is($data[date('Y-m-d', strtotime('-2 day'))], '82', 'getEffortDataForChart() retrieves the right log times');


$projects = Doctrine::getTable('Project')->createQuery()->where('id = ? OR id = ?', array(1,2))->execute();
$report = Doctrine::getTable('Project')->getReportsOnProjectsWithEffortChart($projects);

$t->is($report[1]['completion_percentage'], '43.48', '->getReportsForRecentProjects() the right completion_percentage');
$t->is($report[1]['assigned_percentage'], '4.35', '->getReportsForRecentProjects() the right remaining_issues');
$t->is($report[1]['closed_issues'], '10', '->getReportsForRecentProjects() the right closed_issues');
$t->is($report[1]['remaining_issues'], '13', '->getReportsForRecentProjects() the right remaining_issues');
$t->is($report[1]['messages'], 0, '->getReportsForRecentProjects() the right messages');

$t->is(count($report[1]['chart']), 14, '->getReportsForRecentProjects() the right chart');

$t->is($report[2]['completion_percentage'], '0', '->getReportsForRecentProjects() the right completion_percentage');
$t->is($report[2]['assigned_percentage'], '0', '->getReportsForRecentProjects() the right remaining_issues');
$t->is($report[2]['closed_issues'], '0', '->getReportsForRecentProjects() the right closed_issues');
$t->is($report[2]['remaining_issues'], '7', '->getReportsForRecentProjects() the right remaining_issues');
$t->is($report[2]['messages'], 2, '->getReportsForRecentProjects() the right messages');

$t->is(count($report[2]['chart']), 14, '->getReportsForRecentProjects() the right chart');

