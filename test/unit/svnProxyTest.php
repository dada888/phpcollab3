<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idMockStubGenerator/lib/Mock-Stub-Generator/FakeObjectGenerator.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/commands/SvnProxy.class.php');
include(dirname(__FILE__).'/../svnFakeRepositoryCreator.php');

//setup
$rvm = new ReturnValuesManager('Command');
$rvm->setReturnValue('getSubCommandName', 'subCommandName ')
->setReturnValue('getOptionList', '--option value --option value ');
FakeObjectGenerator::generate($rvm);

$localRepositoryServerPath = sfConfig::get('sf_test_dir')."/fixtures/svn";
$localRepositoryClientPath = sfConfig::get('sf_cache_dir')."/fixtures/svn_client";
$svnRepCreator = new svnFakeRepositoryCreator();

$t = new lime_test(10, new lime_output_color());
$svnRepCreator->readFakeRepository($t, $localRepositoryServerPath, $localRepositoryClientPath, 'newProject');
$svn_proxy = new SvnProxy('file:///'.$localRepositoryServerPath.'/newProject');

$svn_proxy->getCommand();
$t->is($svn_proxy->getCommand(), 'svn file:///'.$localRepositoryServerPath.'/newProject', '->getCommand() returns the right value');

$svn_proxy->addOptionConfigDir('directory_path');
$t->is($svn_proxy->getCommand(), 'svn --config-dir directory_path file:///'.$localRepositoryServerPath.'/newProject', '->addOptionConfigDir(dir_path) add the right option');

$svn_proxy->addOptionNoAuthCache();
$t->is($svn_proxy->getCommand(), 'svn --config-dir directory_path --no-auth-cache file:///'.$localRepositoryServerPath.'/newProject', '->addOptionNoAuthCache() add the right option');

$svn_proxy->addOptionNonInteractive();
$t->is($svn_proxy->getCommand(), 'svn --config-dir directory_path --no-auth-cache --non-interactive file:///'.$localRepositoryServerPath.'/newProject', '->addOptionNonInteractive() add the right option');

$svn_proxy->addOptionPassword('pippo');
$t->is($svn_proxy->getCommand(), 'svn --config-dir directory_path --no-auth-cache --non-interactive --password pippo file:///'.$localRepositoryServerPath.'/newProject', '->addOptionPassword($password) add the right option');

$svn_proxy->addOptionUsername('pippo');
$t->is($svn_proxy->getCommand(), 'svn --config-dir directory_path --no-auth-cache --non-interactive --password pippo --username pippo file:///'.$localRepositoryServerPath.'/newProject', '->addOptionUsername($username) add the right option');

$svn_proxy->setOutputToFile('file_path');
$t->is($svn_proxy->getCommand(), 'svn --config-dir directory_path --no-auth-cache --non-interactive --password pippo --username pippo file:///'.$localRepositoryServerPath.'/newProject > file_path ', '->setOutputToFile(file_path) add the right option');

$mock_object = new Command();
$svn_proxy->setSubCommand($mock_object);
$t->is($svn_proxy->getCommand(), 'svn --config-dir directory_path --no-auth-cache --non-interactive --password pippo --username pippo subCommandName --option value --option value file:///'.$localRepositoryServerPath.'/newProject > file_path ', '->setSubCommand($object) add the right option');

$t->is($svn_proxy->getFilePath(), 'file_path', '->getFilePath() return the right value');

$t->is($svn_proxy->getUrl(), 'file:///'.$localRepositoryServerPath.'/newProject', '->getUrl() returns the right value.');
