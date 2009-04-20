<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/commands/GitLogCommand.class.php');
include(dirname(__FILE__).'/../../plugins/idMockStubGenerator/lib/Mock-Stub-Generator/FakeObjectGenerator.php');

$rvm = new ReturnValuesManager('GitLogFormat');
$rvm->setReturnValue('getLogFormat', 'format');
FakeObjectGenerator::generate($rvm);

$gitLogCommand = new GitLogCommand();

$t = new lime_test(16, new lime_output_color());

$gitLogCommand->addOptionAll();
$t->is($gitLogCommand->getOptionList(), '--all ', '->addOptionAll() set the right option');

$gitLogCommand->addOptionAllMatch();
$t->is($gitLogCommand->getOptionList(), '--all --all-match ', '->addOptionAllMatch() set the right option');

$gitLogCommand->addOptionAuthor('regexp');
$t->is($gitLogCommand->getOptionList(), '--all --all-match --author=regexp ', '->addOptionAuthor(regexp) set the right option');

$gitLogCommand->addOptionBranches();
$t->is($gitLogCommand->getOptionList(), '--all --all-match --author=regexp --branches ', '->addOptionBranches() set the right option');

$gitLogCommand->addOptionCommitter('regexp');
$t->is($gitLogCommand->getOptionList(), '--all --all-match --author=regexp --branches --committer=regexp ', '->addOptionCommitter(regexp) set the right option');

$gitLogCommand->addOptionFixedStrings();
$t->is($gitLogCommand->getOptionList(), '--all --all-match --author=regexp --branches --committer=regexp --fixed-strings ', '->addOptionFixedStrings() set the right option');

$gitLogCommand->addOptionGrep('regexp');
$t->is($gitLogCommand->getOptionList(),
 '--all --all-match --author=regexp --branches --committer=regexp --fixed-strings --grep=regexp ',
 '->addOptionGrep(regexp) set the right option');

$gitLogCommand->addOptionLimit(10);
$t->is($gitLogCommand->getOptionList(),
 '--all --all-match --author=regexp --branches --committer=regexp --fixed-strings --grep=regexp -n 10 ',
 '->addOptionLimit(10) set the right option');

$gitLogCommand->addOptionMaxCounter(100);
$t->is($gitLogCommand->getOptionList(),
 '--all --all-match --author=regexp --branches --committer=regexp --fixed-strings --grep=regexp -n 10 --max-count=100 ',
 '->addOptionMaxCounter(100) set the right option');

$gitLogCommand->addOptionRemotes();
$t->is($gitLogCommand->getOptionList(),
 '--all --all-match --author=regexp --branches --committer=regexp --fixed-strings --grep=regexp -n 10 --max-count=100 --remotes ',
 '->addOptionRemotes() set the right option');

$gitLogCommand->addOptionSince('date');
$t->is($gitLogCommand->getOptionList(),
 '--all --all-match --author=regexp --branches --committer=regexp --fixed-strings --grep=regexp -n 10 --max-count=100 --remotes --since=date ',
 '->addOptionSince(date) set the right option');

$gitLogCommand->addOptionSkip(25);
$t->is($gitLogCommand->getOptionList(),
 '--all --all-match --author=regexp --branches --committer=regexp --fixed-strings --grep=regexp -n 10 --max-count=100 --remotes --since=date --skip=25 ',
 '->addOptionSkip(25) set the right option');

$gitLogCommand->addOptionUntil('date');
$t->is($gitLogCommand->getOptionList(),
 '--all --all-match --author=regexp --branches --committer=regexp --fixed-strings --grep=regexp -n 10 --max-count=100 --remotes --since=date --skip=25 --until=date ',
 '->addOptionUntil(date) set the right option');

$t->is($gitLogCommand->getSubCommandName(),'git log ', '->getSubCommandName() returns the right value');

$gitLogCommand->addOptionPrettyFormat(new GitLogFormat());
$t->is($gitLogCommand->getOptionList(),
 '--all --all-match --author=regexp --branches --committer=regexp --fixed-strings --grep=regexp -n 10 --max-count=100 --remotes --since=date --skip=25 --until=date --pretty=format:format ',
 '->addOptionPrettyFormat(format) set the right option');

$gitLogCommand->addPath('path');
$t->is($gitLogCommand->getCommandToString(),
  'git log --all --all-match --author=regexp --branches --committer=regexp --fixed-strings --grep=regexp -n 10 --max-count=100 --remotes --since=date --skip=25 --until=date --pretty=format:format path ',
  'getCommandToString() returns the right value.'
);