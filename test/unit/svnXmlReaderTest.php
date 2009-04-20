<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../svnFakeRepositoryCreator.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/xmlHandler/SvnXmlReader.class.php');


$localRepositoryServerPath = sfConfig::get('sf_test_dir')."/fixtures/svn";
$localRepositoryClientPath = sfConfig::get('sf_test_dir')."/fixtures/svn_client";
$filepath = dirname(__FILE__).'/../../cache/svn.xml';
$svnRepCreator = new svnFakeRepositoryCreator();

$t = new lime_test(4, new lime_output_color());
$svnRepCreator->readFakeRepository($t, $localRepositoryServerPath, $localRepositoryClientPath, 'newProject');
$svnRepCreator->createLogFile($filepath);

$svn_xml_reader = new SvnXmlReader($filepath);

$array = $svn_xml_reader->readLog();
$t->ok(is_array($array), 'svnXmlReader reads the right file.');

$t->ok(!empty($array), 'the array of resuilts is not empty.');

$t->is(count($array), 1, 'the array of resuilts has the right amount of elements.');

$t->is($svn_xml_reader->getFilePath(), dirname(__FILE__).'/../../cache/svn.xml', '->getFilePath() returns the right file path.');

unlink(dirname(__FILE__).'/../../cache/svn.xml');