<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/commands/DiffCommandFactory.class.php');

Class RepositoryFactory
{
  const svn = 'svn';
  const git = 'git';
}

$t = new lime_test(3, new lime_output_color());

$t->comment('::init()');
$factory = DiffCommandFactory::init();
$t->is($factory instanceof DiffCommandFactory, true, '->__construst() return right instance of DiffCommandFactory');

$t->comment('->build()');
$command = $factory->build('svn');
$t->is($command instanceof SvnDiffCommand, true, '->build() return right SvnDiffCommand');
$command = $factory->build('git');
$t->is($command instanceof GitDiffCommand, true, '->build() return right GitDiffCommand');