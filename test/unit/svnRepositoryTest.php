<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idMockStubGenerator/lib/Mock-Stub-Generator/FakeObjectGenerator.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/SvnRepository.class.php');

//setup
$rvm_data = new ReturnValuesManager('LogData');

$rvm = new ReturnValuesManager('SvnProxy');
FakeObjectGenerator::generate($rvm);

$rvm = new ReturnValuesManager('SvnXmlReader');
//Set input parameter for method readLog : for the time being the fake method cannot have in input an object
$rvm->setReturnObjectsArray('readLog', array($rvm_data,$rvm_data,$rvm_data,$rvm_data,$rvm_data,$rvm_data,$rvm_data,$rvm_data,$rvm_data,$rvm_data));
FakeObjectGenerator::generate($rvm);

$rvm = new ReturnValuesManager('SvnLogCommand');
FakeObjectGenerator::generate($rvm);

$rvm = new ReturnValuesManager('DiffParser');
$rvm->setReturnObject('parse', 'DiffParser_mock');
FakeObjectGenerator::generate($rvm);

$rvm = new ReturnValuesManager('SvnDiffCommand');
FakeObjectGenerator::generate($rvm);

$mock_proxy = new SvnProxy();
$mock_reader = new SvnXmlReader();
$repository = new SVNRepository($mock_proxy, $mock_reader);
$mock_logcommand = new SvnLogCommand();
$data = $repository->getLogLatestRevisions($mock_logcommand);



$t = new lime_test(8, new lime_output_color());

$t->diag('SVNRepository');

$t->diag('->getLogLatestRevisions()');
$t->ok(is_array($data), '->getLogLatestRevisions() returns an array');
$t->ok($data[0] instanceof LogData, '->getLogLatestRevisions() returns an array of LogData objects');
$t->is(count($data), 10, '->getLogLatestRevisions() returns an array of XmlLogData objects');

$data = $repository->getAllLogRevisions($mock_logcommand);
$t->diag('->getAllLogRevisions()');
$t->ok(is_array($data), '->getAllLogRevisions() returns an array');
$t->ok($data[0] instanceof LogData, '->getAllLogRevisions() returns an array of LogData objects');

$data = $repository->getAllRevisionForPath('path',$mock_logcommand);
$t->diag('->getLogAllRevisionForPath()');
$t->ok(is_array($data), '->getLogAllRevisionForPath() returns an array');
$t->ok($data[0] instanceof LogData, '->getLogAllRevisionForPath() returns an array of LogData objects');

$data = $repository->getDiffMatrixFromRevision('10', '15', new DiffParser(), new SvnDiffCommand());
$t->diag('->getDiffMatrixFromRevision()');
$t->ok($data instanceof DiffParser, '->getDiffMatrixFromRevision() returns an array');



