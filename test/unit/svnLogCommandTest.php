<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/commands/SvnLogCommand.class.php');

$t = new lime_test(16, new lime_output_color());

$command = new SvnLogCommand();

$t->diag('SvnLogCommand');

$t->is($command->getOptionList(),'','->getOptionList() returns an empty string');

$command->addOptionAllRevisionProperties();
$t->is($command->getOptionList(),"--with-all-revprops ",'->getOptionList() returns the right value');

$command->addOptionChange(10);
$t->is($command->getOptionList(),"--with-all-revprops --change 10 ",'->addOptionChange(10) returns the right value');

$command->addOptionIncremental();
$t->is($command->getOptionList(),"--with-all-revprops --change 10 --incremental ",'->addOptionIncremental() returns the right value');

$command->addOptionLimit(10);
$t->is($command->getOptionList(),"--with-all-revprops --change 10 --incremental --limit 10 ",'->addOptionIncremental() returns the right value');

$command->addOptionQuiet();
$t->is($command->getOptionList(),"--with-all-revprops --change 10 --incremental --limit 10 --quiet ",'->addOptionQuiet() returns the right value');

$command->addOptionRevision();
$t->is($command->getOptionList(),"--with-all-revprops --change 10 --incremental --limit 10 --quiet --revision HEAD:1 ",'->addOptionRevision() returns the right value');

$command->addOptionStopOnCopy();
$t->is($command->getOptionList(),"--with-all-revprops --change 10 --incremental --limit 10 --quiet --revision HEAD:1 --stop-on-copy ",'->getOptionList() returns the right value');

$command->addOptionVerbose();
$t->is($command->getOptionList(),"--with-all-revprops --change 10 --incremental --limit 10 --quiet --revision HEAD:1 --stop-on-copy --verbose ",'->getOptionList() returns the right value');

$command->addOptionXmlOutput();
$t->is($command->getOptionList(),"--with-all-revprops --change 10 --incremental --limit 10 --quiet --revision HEAD:1 --stop-on-copy --verbose --xml ",'->getOptionList() returns the right value');


$t->is($command->getSubCommandName(),"log ",'->getOptionList() returns the right value');


$command = new SvnLogCommand();
$command->addOptionRevision(100, 50);
$t->is($command->getOptionList(),"--revision 100:50 ",'->addOptionRevision(100, 50) returns the right value');

$command = new SvnLogCommand();
$command->addOptionRevision('HEAD', 'BASE');
$t->is($command->getOptionList(),"--revision HEAD:BASE ",'->getOptionList() returns the right value');

$command = new SvnLogCommand();
$command->addOptionRevision('HEAD', 50);
$t->is($command->getOptionList(),"--revision HEAD:50 ",'->getOptionList() returns the right value');

$command = new SvnLogCommand();
try
{
  $command->addOptionRevision(50, 100);
  $t->fail('no code should be executed after throwing an exception');
}
catch (Exception $e)
{
  $t->pass('->addOptionRevision(50, 100) exception catched successfully');
}

$command = new SvnLogCommand();
try
{
  $command->addOptionRevision(50, 'HEAD');
  $t->fail('no code should be executed after throwing an exception');
}
catch (Exception $e)
{
  $t->pass('->addOptionRevision(50, HEAD) exception catched successfully');
}
