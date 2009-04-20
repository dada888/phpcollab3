<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/fileHandler/FileLogData.class.php');

$fileLogData = new FileLogData();

$t = new lime_test(13, new lime_output_color());

$fileLogData->setLogRevisionNumber(2);
$t->is($fileLogData->getLogRevisionNumber(), 2, '->getLogRevisionNumber() returns the right value');

$fileLogData->setAuthor('bob');
$t->is($fileLogData->getAuthor(), 'bob', '->getAuthor() returns the right value');

$fileLogData->setDate('20-12-2009');
$t->is($fileLogData->getDate(), '20-12-2009', '->getDate() returns the right value');

$fileLogData->setMessage('message');
$t->is($fileLogData->getMessage(), 'message', '->getMessage() returns the right value');

$fileLogData->setPath('A', 'addedd/addedddddd.file');
$fileLogData->setPath('M', 'addedd/addedddddd2.file');
$fileLogData->setPath('M', 'addedd/addedddddd3.file');
$fileLogData->setPath('D', 'addedd/addedddddd4.file');
$t->ok(is_array($fileLogData->getPaths()), '->getPaths() returns an array');
$array = $fileLogData->getPaths();
$t->is($array[0]['action'], 'A', '->getPaths() returns the right value for action');
$t->is($array[0]['path'], 'addedd/addedddddd.file', '->getPaths() returns the right value for path');
$t->is($array[1]['action'], 'M', '->getPaths() returns the right value for action');
$t->is($array[1]['path'], 'addedd/addedddddd2.file', '->getPaths() returns the right value for path');
$t->is($array[2]['action'], 'M', '->getPaths() returns the right value for action');
$t->is($array[2]['path'], 'addedd/addedddddd3.file', '->getPaths() returns the right value for path');
$t->is($array[3]['action'], 'D', '->getPaths() returns the right value for action');
$t->is($array[3]['path'], 'addedd/addedddddd4.file', '->getPaths() returns the right value for path');
