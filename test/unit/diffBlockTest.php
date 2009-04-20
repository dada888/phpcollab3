<?php
include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idMockStubGenerator/lib/Mock-Stub-Generator/FakeObjectGenerator.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/fileHandler/DiffBlock.class.php');

$t = new lime_test(73, new lime_output_color());

$rvm = new ReturnValuesManager('DiffLine');
$rvm->setReturnValue("__toString", "not empty line", 1)
->setReturnValue("__toString", "not empty line", 2)
->setReturnValue("__toString", "not empty line", 3)
->setReturnValue("__toString", "not empty line", 4)
->setReturnValue("__toString", "not empty line", 5)
->setReturnValue("__toString", "not empty line", 6)
;

$rvm->setInputParameterForMethod('setLineNumber', array(12), 1)
->setInputParameterForMethod('setLineNumber', array(13), 2)
->setInputParameterForMethod('setLineNumber', array(14), 3)
->setInputParameterForMethod('setLineNumber', array(15), 4)
->setInputParameterForMethod('setLineNumber', array(16), 5)
->setInputParameterForMethod('setLineNumber', array(17), 6);

$rvm->setReturnValue("getStatus", "empty", 1)
->setReturnValue("getStatus", "empty", 2)
->setReturnValue("getStatus", "+", 3)
->setReturnValue("getStatus", "empty", 4)
->setReturnValue("getStatus", "+", 5)
->setReturnValue("getStatus", "+", 6)
->setReturnValue("getStatus", "+", 7)
->setReturnValue("getStatus", "+", 8)
->setReturnValue("getStatus", "empty", 9)
->setReturnValue("getStatus", "+", 10)
;

FakeObjectGenerator::generate($rvm);

$diffLine = new DiffLine();

$t->diag('Exception catch in constructor');
try
{
  $block = new DiffBlock('');
  $t->fail('Not throw an exception');
}
catch(Exception $e)
{
  $t->is($e->getMessage(), 'Line number must be a positive integer or zero [ given ]', '->__construct() throw the right exception');
}

$block = new DiffBlock(12);

$t->diag('Getting the right number for start line of a block');
$t->is($block->getStartLineNumber(), '12', '->getStartLineNumber() retuirns the right value');

//empty line (2)
$t->diag('1) Adding an empty line');
$block->addLine($diffLine);

$t->is($block->getEmptyLine(), 1, '->getEmptyLine() returns the right value');
$t->ok(is_array($block->getLines()), '->getLines() returns an array');
$t->is(count($block->getLines()), 1, '->getLines() returns an array with the right number of element');
$t->is($block->getNumberOfLines(), 0, '->getNumberOfLines() return the right value');
$array = $block->getLines();
$t->isa_ok($array[0], DiffLine, '->getLines() returns an array of DiffLine elements');

//empty line (3)
$t->diag('2) Adding an empty line');
$block->addLine($diffLine);

$t->is($block->getEmptyLine(), 2, '->getEmptyLine() returns the right value');
$t->ok(is_array($block->getLines()), '->getLines() returns an array');
$t->is(count($block->getLines()), 2, '->getLines() returns an array with the right number of element');
$t->is($block->getNumberOfLines(), 0, '->getNumberOfLines() return the right value');
$array = $block->getLines();
$t->isa_ok($array[0], DiffLine, '->getLines() returns an array of DiffLine elements');
$t->isa_ok($array[1], DiffLine, '->getLines() returns an array of DiffLine elements');

//not empty line (4)
$t->diag('3) Adding an NOT empty line');
$block->addLine($diffLine);

$array = $block->getLines();
$t->is($block->getEmptyLine(), 1, '->getEmptyLine() returns the right value');
$t->ok(is_array($block->getLines()), '->getLines() returns an array');
$t->is(count($block->getLines()), 2, '->getLines() returns an array with the right number of element');
$t->is($block->getNumberOfLines(), 1, '->getNumberOfLines() return the right value');
$t->isa_ok($array[0], DiffLine, '->getLines() returns an array of DiffLine elements');

$diff_line = $array[0];
$t->is($diff_line->__toString(), 'not empty line', 'DiffLine element contains the exact value');
$t->isa_ok($array[1], DiffLine, '->getLines() returns an array of DiffLine elements');

//empty line again (5)
$t->diag('4) Adding an empty line');
$block->addLine($diffLine);

$t->is($block->getEmptyLine(), 2, '->getEmptyLine() returns the right value');
$t->ok(is_array($block->getLines()), '->getLines() returns an array');
$t->is(count($block->getLines()), 3, '->getLines() returns an array with the right number of element');
$t->is($block->getNumberOfLines(), 1, '->getNumberOfLines() return the right value');
$array = $block->getLines();
$t->isa_ok($array[0], DiffLine, '->getLines() returns an array of DiffLine elements');
$diff_line = $array[0];
$t->is($diff_line->__toString(), 'not empty line', 'DiffLine element contains the exact value');
$t->isa_ok($array[1], DiffLine, '->getLines() returns an array of DiffLine elements');
$t->isa_ok($array[2], DiffLine, '->getLines() returns an array of DiffLine elements');

//reset empty line
$t->diag('5) reset empty line number');
$block->resetEmptyLineNumber();

$t->is($block->getEmptyLine(), 0, '->resetEmptyLineNumber() resets the value of empty lines as expected');
$t->is($block->getNumberOfLines(), 3, '->getNumberOfLines() return the right value');
$array = $block->getLines();
$t->is(count($array), 3, 'Right number of set lines');
$t->isa_ok($array[0], DiffLine, '->getLines() returns an array of DiffLine elements');
$diff_line = $array[0];
$t->is($diff_line->__toString(), 'not empty line', 'DiffLine element contains the exact value');
$t->isa_ok($array[1], DiffLine, '->getLines() returns an array of DiffLine elements');
$t->isa_ok($array[2], DiffLine, '->getLines() returns an array of DiffLine elements');

//add another not empty line
$t->diag('6) Add NOT empty line');
$block->addLine($diffLine);

$t->is($block->getEmptyLine(), 0, '->getEmptyLine() returns the right value');
$t->ok(is_array($block->getLines()), '->getLines() returns an array');
$t->is(count($block->getLines()), 4, '->getLines() returns an array with the right number of element');
$t->is($block->getNumberOfLines(), 4, '->getNumberOfLines() return the right value');
$array = $block->getLines();
$t->isa_ok($array[0], DiffLine, '->getLines() returns an array of DiffLine elements');
$diff_line = $array[0];
$t->is($diff_line->__toString(), 'not empty line', 'DiffLine element contains the exact value');
$t->isa_ok($array[1], DiffLine, '->getLines() returns an array of DiffLine elements');
$t->isa_ok($array[2], DiffLine, '->getLines() returns an array of DiffLine elements');
$t->ok(isset($array[3]), 'therd line reported correctly');
$diff_line = $array[3];
$t->is($diff_line->__toString(), 'not empty line', 'DiffLine element contains the exact value');

$t->diag('7) Add NOT empty line');
$block->addLine($diffLine);

$t->is($block->getEmptyLine(), 0, '->getEmptyLine() returns the right value');
$t->ok(is_array($block->getLines()), '->getLines() returns an array');
$t->is(count($block->getLines()), 5, '->getLines() returns an array with the right number of element');
$t->is($block->getNumberOfLines(), 5, '->getNumberOfLines() return the right value');


$t->diag('Tests for problems found testing diffFileHandler and connected with DiffBlock');

$t->diag('Reset Empty line number');
$block->resetEmptyLineNumber();
$t->is($block->getEmptyLine(), 0, '->resetEmptyLineNumber() resets the value as expected');
$t->is(count($block->getLines()), 5, '->getLines() returns an array with the right number of element');
$t->is($block->getNumberOfLines(), 5, '->getNumberOfLines() return the right value');

$t->diag('Add not empty line');
$block->addLine($diffLine);

$t->is($block->getEmptyLine(), 0, '->getEmptyLine() returns the right value');
$t->ok(is_array($block->getLines()), '->getLines() returns an array');
$t->is(count($block->getLines()), 6, '->getLines() returns an array with the right number of element');
$t->is($block->getNumberOfLines(), 6, '->getNumberOfLines() return the right value');

$t->diag('Add not empty line');
$block->addLine($diffLine);

$t->is($block->getEmptyLine(), 0, '->getEmptyLine() returns the right value');
$t->ok(is_array($block->getLines()), '->getLines() returns an array');
$t->is(count($block->getLines()), 7, '->getLines() returns an array with the right number of element');
$t->is($block->getNumberOfLines(), 7, '->getNumberOfLines() return the right value');

$t->diag('Add empty line');
$block->addLine($diffLine);

$t->is($block->getEmptyLine(), 1, '->getEmptyLine() returns the right value');
$t->ok(is_array($block->getLines()), '->getLines() returns an array');
$t->is(count($block->getLines()), 8, '->getLines() returns an array with the right number of element');
$t->is($block->getNumberOfLines(), 7, '->getNumberOfLines() return the right value');

$t->diag('Reset Empty line number');
$block->resetEmptyLineNumber();
$t->is($block->getEmptyLine(), 0, '->resetEmptyLineNumber() resets the value as expected');
$t->is(count($block->getLines()), 8, '->getLines() returns an array with the right number of element');
$t->is($block->getNumberOfLines(), 8, '->getNumberOfLines() return the right value');

$t->diag('Add not empty line');
$block->addLine($diffLine);

$t->is($block->getEmptyLine(), 0, '->getEmptyLine() returns the right value');
$t->ok(is_array($block->getLines()), '->getLines() returns an array');
$t->is(count($block->getLines()), 9, '->getLines() returns an array with the right number of element');
$t->is($block->getNumberOfLines(), 9, '->getNumberOfLines() return the right value');


$t->diag('->getLine($index)');
$line = $block->getLine(3);
$t->ok($line instanceof DiffLine, '->getLine($index) returns the right value');
$t->is($line->__toString(), 'not empty line', '->getLine($index) returns the right value');


















