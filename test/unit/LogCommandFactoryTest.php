<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/commands/LogCommandFactory.class.php');

Class RepositoryFactory
{
  const svn = 'svn';
  const git = 'git';
}

$t = new lime_test(3, new lime_output_color());

$t->comment('::init()');
$factory = LogCommandFactory::init();
$t->is($factory instanceof LogCommandFactory, true, '->__construst() return right instance of LogCommandFactory');

$t->comment('->build()');
$command = $factory->build('svn');
$t->is($command instanceof SvnLogCommand, true, '->build() return right SvnLogCommand');
$command = $factory->build('git');
$t->is($command instanceof GitLogCommand, true, '->build() return right GitLogCommand');