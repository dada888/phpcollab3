<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/fileHandler/FactoryLine.class.php');
include(dirname(__FILE__).'/../../plugins/idMockStubGenerator/lib/Mock-Stub-Generator/FakeObjectGenerator.php');

//setup
$rvm = new ReturnValuesManager('DiffBlockLine');
FakeObjectGenerator::generate($rvm);
$rvm = new ReturnValuesManager('DiffLine');
FakeObjectGenerator::generate($rvm);

$t = new lime_test(7, new lime_output_color());



$t->comment('::init()');
$factory = FactoryLine::init();
$t->is($factory instanceof FactoryLine, true, '->__construst() return right instance of LogCommandFactory');

$t->comment('->build()');
$line = $factory->build('@@ -1,6 +1,9 @@');
$t->is($line instanceof DiffBlockLine, true, '->build() return right DiffBlock');
$line = $factory->build('+file12.php');
$t->is($line instanceof DiffLine, true, '->build() return right DiffLine');
$line = $factory->build('-file12.php');
$t->is($line instanceof DiffLine, true, '->build() return right DiffLine');
$line = $factory->build(' file12.php');
$t->is($line instanceof DiffLine, true, '->build() return right DiffLine');
$line = $factory->build(' ');
$t->is($line instanceof DiffLine, true, '->build() return right DiffLine');
$line = $factory->build('@');
$t->is($line instanceof DiffLine, true, '->build() return right DiffLine');
