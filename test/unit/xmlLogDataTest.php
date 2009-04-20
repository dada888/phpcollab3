<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/xmlHandler/XmlLogData.class.php');

$xmlLogData = new XmlLogData();

$t = new lime_test(13, new lime_output_color());

$xmlLogData->setLogRevisionNumber(2);
$t->is($xmlLogData->getLogRevisionNumber(), 2, '->getLogRevisionNumber() returns the right value');

$xmlLogData->setAuthor('bob');
$t->is($xmlLogData->getAuthor(), 'bob', '->getAuthor() returns the right value');

$xmlLogData->setDate('20-12-2009');
$t->is($xmlLogData->getDate(), '20-12-2009', '->getDate() returns the right value');

$xmlLogData->setMessage('message');
$t->is($xmlLogData->getMessage(), 'message', '->getMessage() returns the right value');

$xmlLogData->setPath('A', 'addedd/addedddddd.file');
$xmlLogData->setPath('M', 'addedd/addedddddd2.file');
$xmlLogData->setPath('M', 'addedd/addedddddd3.file');
$xmlLogData->setPath('D', 'addedd/addedddddd4.file');
$t->ok(is_array($xmlLogData->getPaths()), '->getPaths() returns an array');
$array = $xmlLogData->getPaths();
$t->is($array[0]['action'], 'A', '->getPaths() returns the right value for action');
$t->is($array[0]['path'], 'addedd/addedddddd.file', '->getPaths() returns the right value for path');
$t->is($array[1]['action'], 'M', '->getPaths() returns the right value for action');
$t->is($array[1]['path'], 'addedd/addedddddd2.file', '->getPaths() returns the right value for path');
$t->is($array[2]['action'], 'M', '->getPaths() returns the right value for action');
$t->is($array[2]['path'], 'addedd/addedddddd3.file', '->getPaths() returns the right value for path');
$t->is($array[3]['action'], 'D', '->getPaths() returns the right value for action');
$t->is($array[3]['path'], 'addedd/addedddddd4.file', '->getPaths() returns the right value for path');
