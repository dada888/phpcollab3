<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/fileHandler/GitLogFileHandler.class.php');
include(dirname(__FILE__).'/../gitFakeRepositoryCreator.php');

$gitRepositoryPath = dirname(__FILE__).'/../fixtures/git';
$gitLogFilePath = dirname(__FILE__).'/../../cache/gitLogFile';
$prefix = 'prefix';
$suffix = 'suffix';

$gitRepositoryCreator = new gitFakeRepositoryCreator();
$gitRepositoryCreator->readFakeRepository($gitRepositoryPath);
$gitRepositoryCreator->createGitLogFile($gitRepositoryPath, $gitLogFilePath, $prefix, $suffix);



$gitLogFileHandler = new GitLogFileHandler($gitLogFilePath,'|', $prefix, $suffix);

$t = new lime_test(6, new lime_output_color());

$t->is($gitLogFileHandler->getFilePath(), $gitLogFilePath, '->getFilePath() returns the right value');

$t->is($gitLogFileHandler->getSeparator(), '|', '->getSeparator() returns the right value');

$t->is($gitLogFileHandler->getPrefix(), $prefix, '->getPrefix() return the right value.');

$t->is($gitLogFileHandler->getSuffix(), $suffix, '->getSuffix() return the right value.');

$array = $gitLogFileHandler->getLog();

$t->ok(is_array($array), '->getLog() returns an array');

$t->ok($array['a8e0aab'] instanceof LogData, '->getLog() returns an array of LogData objects');

unlink($gitLogFilePath);