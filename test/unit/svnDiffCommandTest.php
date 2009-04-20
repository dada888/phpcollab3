<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/commands/SvnDiffCommand.class.php');

$t = new lime_test(4, new lime_output_color());

$command = new SvnDiffCommand();

$t->diag('SvnDiffCommand');

$t->is($command->getOptionList(), '', '->getOptionList() returns the right value');

$command->setOptionRevision();
$t->is($command->getOptionList(), '-r 1:HEAD ', '->getOptionList() returns the right value');

$command = new SvnDiffCommand();

$command->setOptionRevision(35, 45);
$t->is($command->getOptionList(), '-r 35:45 ', '->getOptionList() returns the right value');

$t->is($command->getSubCommandName(), 'diff ', '->getSubCommandName() returns the right value');