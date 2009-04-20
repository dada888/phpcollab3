<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/RepositoryFactory.class.php');

$t = new lime_test(3, new lime_output_color());

$config_repository = array('local_repository' => '/var/www', 'local_log_file' => '/var/www', 'separator' => '', 'prefix' => '', 'suffix');

Class GitLogFileHandler
{
  
}

$t->comment('::init()');
$factory = RepositoryFactory::init();
$t->is($factory instanceof RepositoryFactory, true, '->__construst() return right instance of LogCommandFactory');

$t->comment('->build()');
$command = $factory->build('svn', $config_repository);
$t->is($command instanceof SvnRepository, true, '->build() return right SvnLogCommand');
$command = $factory->build('git', $config_repository);
$t->is($command instanceof GitRepository, true, '->build() return right GitLogCommand');