<?php

include(dirname(__FILE__).'/../bootstrap/unit.php');
include(dirname(__FILE__).'/../../plugins/idRepositoryPlugin/lib/fileHandler/DiffParser.class.php');

$file_path = dirname(__FILE__).'/../fixtures/complexdiff.diff';

$diffParser = new DiffParser();

$t = new lime_test(22, new lime_output_color());

$diffParser->parse(file($file_path));

$t->diag('1 - Checking if the result is atwo dimensional array');
$t->ok(is_array($diffParser->getLeftBlocks()), '->getLeftBlocks() returns an array');
$t->ok(is_array($diffParser->getRightBlocks()), '->getRightBlocks() returns an array');

$t->diag('2 - Checking the array left and right');
$t->is(count($diffParser->getLeftBlocks()), 2, 'left side: diff blocks number is right');
$t->is(count($diffParser->getRightBlocks()), 2, 'right side: diff blocks number is right');

$left_blocks = $diffParser->getLeftBlocks();
$right_blocks = $diffParser->getRightBlocks();

$first_left_block = $left_blocks[0];
$t->is($first_left_block->getStartLineNumber(), '29', 'left (first) start line number is right');

$second_left_block = $left_blocks[1];
$t->is($second_left_block->getStartLineNumber(), '65', 'left (second) start line number is right');

$first_right_block = $right_blocks[0];
$t->is($first_right_block->getStartLineNumber(), '29', 'right (first) start line number is right');

$second_right_block = $right_blocks[1];
$t->is($second_right_block->getStartLineNumber(), '66', 'right (second) start line number is right');


$t->diag('3 - Checking the values into left array (first block)');

$left_lines = $first_left_block->getLines();


$t->ok(is_array($left_lines), '->getLines() returns an array.');
$t->ok($left_lines[0] instanceof DiffLine, '->getLines() returns an array of DiffLine Elements');

$empty_element = $left_lines[3];
$t->is($empty_element->__toString(), "", 'the empty line of the first block is reported correctly');

$t->diag('4 - Checking the values into left array (second block)');
$left_lines = $second_left_block->getLines();
$t->ok(is_array($left_lines), '->getLines() returns an array.');
$t->ok($left_lines[1] instanceof DiffLine, '->getLines() returns an array of DiffLine Elements');
$empty_element = $left_lines[3];
$t->is($empty_element->__toString(), '  private function insertLeftLine($line)', 'one different line of the second block is reported correctly');
$empty_element = $left_lines[4];
$t->is($empty_element->__toString(), '  {', 'one equal line of the second block is reported correctly');


$t->diag('5 - Checking the values into right array (first block)');

$right_lines = $first_right_block->getLines();
$t->ok(is_array($right_lines), '->getLines() returns an array.');
$t->ok($right_lines[0] instanceof DiffLine, '->getLines() returns an array of DiffLine Elements');
$empty_element = $right_lines[3];
$t->is($empty_element->__toString(), '    return $lines;', 'the added line of the first block is reported correctly');

$t->diag('6 - Checking the values into right array (second block)');
$right_lines = $second_right_block->getLines();
$t->ok(is_array($right_lines), '->getLines() returns an array.');
$t->ok($right_lines[0] instanceof DiffLine, '->getLines() returns an array of DiffLine Elements');

$empty_element = $right_lines[3];
$t->is($empty_element->__toString(), '  private function insertLine($direction, $params = array())', 'one different line of the second block is reported correctly');
$empty_element = $right_lines[4];
$t->is($empty_element->__toString(), '  {', 'one equal line of the second block is reported correctly');
