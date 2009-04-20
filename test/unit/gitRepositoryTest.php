<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idMockStubGenerator/lib/Mock-Stub-Generator/FakeObjectGenerator.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/GitRepository.class.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/fileHandler/GitLogFileHandler.class.php');

include(dirname(__FILE__).'/../gitFakeRepositoryCreator.php');

$gitRepositoryPath = dirname(__FILE__).'/../fixtures/git';
$gitLogFile = dirname(__FILE__).'/../../cache/gitLogFile';
$separator = '|';
$prefix = 'revision:';
$suffix = '<<_END_>>';

$gitRepositoryCreator = new gitFakeRepositoryCreator();
$gitRepositoryCreator->readFakeRepository($gitRepositoryPath);
$gitRepositoryCreator->createGitLogFile($gitRepositoryPath, $gitLogFile, $prefix, $suffix);

$repository = new GitRepository($gitRepositoryPath, new GitLogFileHandler($gitLogFile, $separator, $prefix, $suffix));
$t = new lime_test(7, new lime_output_color());

$data = $repository->getLogLatestRevisions(new GitLogCommand());

$t->diag('GITRepository');
$t->ok(is_dir($gitRepositoryPath), 'new GitRepository() local git repository present.');


$t->diag('->getLogLatestRevisions()');
$t->ok(is_array($data), '->getLogLatestRevisions() returns an array');
$t->ok($data['ee05abb'] instanceof LogData, '->getLogLatestRevisions() returns an array of LogData objects');
$t->is(count($data), 10, '->getLogLatestRevisions() returns an array of 10 elements');

$gitCommand = new GitLogCommand();
$gitCommand->addOptionMaxCounter(50);

$data = $repository->getAllLogRevisions($gitCommand);
$t->diag('->getAllLogRevisions()');
$t->ok(is_array($data), '->getAllLogRevisions() returns an array');
$t->ok($data['ee05abb'] instanceof LogData, '->getAllLogRevisions() returns an array of LogData objects');
$t->is(count($data), 50, '->getAllLogRevisions() returns an array of 15 elements');

unlink(dirname(__FILE__).'/../../cache/gitLogFile');
