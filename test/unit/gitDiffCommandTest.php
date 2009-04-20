<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/commands/GitDiffCommand.class.php');

$t = new lime_test(4, new lime_output_color());

$command = new GitDiffCommand();

$t->diag('GitDiffCommand');

$t->is($command->getOptionList(), '', '->getOptionList() returns the right value');

$command->addRevisions('abcdefg', '1234567');
$t->is($command->getOptionList(), 'abcdefg 1234567 ', '->getOptionList() returns the right value');

$t->is($command->getSubCommandName(), 'git diff ', '->getSubCommandName() returns the right value');

$command->addPath('path');
$t->is($command->getCommandToString(), 'git diff abcdefg 1234567 path ', '->getSubCommandName() returns the right value');